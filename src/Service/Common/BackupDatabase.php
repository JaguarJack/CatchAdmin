<?php
namespace JaguarJack\CatchAdmin\Service\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class BackupDatabase
{
    protected $table;

    protected $backPath;

    /**
     *
     * @time 2019年09月30日
     * @param $tables
     * @param $format
     * @param $path
     * @return void
     */
    public function generator($tables, $format, $path)
    {
        $this->backPath = $path;

        foreach ($tables as $table) {
            $this->table = $table;

            $this->createDataFile($format);
        }
    }

    /**
     * 创建数据文件
     *
     * @time 2019年09月27日
     * @param $format
     * @return void
     */
    public function createDataFile($format)
    {
        $this->createBackUpPath();

        $file = $this->backPath . $this->table . '.' . $format;

        $handle = fopen($file, 'wb+');

        if ($format === 'php') {
            fwrite($handle, $begin = "BEGIN\r\n", strlen($begin));
            $this->createClass($this->table, $format, $handle);
        } else {
            fwrite($handle, $begin = "BEGIN;\r\n", \strlen($begin));
            $this->createClass($this->table, $format, $handle);
            fwrite($handle, $end = 'COMMIT;', \strlen($end));
        }

        fclose($handle);
    }

    /**
     * 创建了临时模型
     *
     * @time 2019年09月27日
     * @param $table
     * @param $format
     * @param $handle
     * @return void
     */
    protected function createClass($table, $format, $handle)
    {
        $this->setUnbuffered();

        // 防止 IO 多次写入
        $buffer = [];

        $model = (new class($table) extends Model{
            public function __construct($table, array $attributes = [])
            {
                parent::__construct($attributes);

                $this->table = $table;
            }
        });
        // 记录中记录
        $total = $model->count();
        // 生成器减少内存
        $model->cursor()->each(function ($item, $key) use ($format, $handle, &$buffer, $total){
            $buffer[] = $item;
            // 末尾直接返回
            if (($key + 1) === $total) {
                $this->{$format . 'Format'}($handle, $this->toArray($buffer));
                // 初始化
                $buffer = [];
            } else if (count($buffer) >= 1500){
                $this->{$format . 'Format'}($handle, $this->toArray($buffer));
                // 初始化
                $buffer = [];
            }
        });
    }

    /**
     * 数组为难格式
     *
     * @time 2019年09月27日
     * @param $handle
     * @param $data
     * @return void
     */
    protected function phpFormat($handle, $data)
    {
        $lineData = base64_encode(serialize($data)) . "\r\n";

        fwrite($handle, $lineData, strlen($lineData));
    }

    /**
     * sql 文件格式
     *
     * @time 2019年09月27日
     * @param $handle
     * @param $data
     * @return void
     */
    protected function sqlFormat($handle, $datas)
    {
        $values = '';
        $sql = '';
        foreach ($datas as $data) {
            foreach ($data as $value) {
                $values .= sprintf("'%s'", $value) . ',';
            }

            $sql .= sprintf('INSERT INTO `%s` VALUE (%s);' . "\r\n", $this->table, rtrim($values, ','));
            $values = '';
        }

        fwrite($handle, $sql, strlen($sql));
    }

    /**
     * 转换成数组格式
     *
     * @time 2019年09月30日
     * @param $data
     * @return mixed
     */
    protected function toArray($data)
    {
        return json_decode(json_encode($data, true));
    }

    /**
     * 设置未缓存模式
     *
     * @time 2019年09月29日
     * @return void
     */
    protected function setUnbuffered()
    {
         Config::set('database.connections.mysql.options', [
           \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false
        ]);
    }

    /**
     * 创建备份文件夹
     *
     * @time 2019年09月26日
     * @return void
     */
    protected function createBackUpPath()
    {
        if (!is_dir($this->backPath)) {
            if (!mkdir($this->backPath, 0777, true) && !is_dir($this->backPath)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $this->backPath));
            }
        }
    }


    protected function zip()
    {
        new \ZipArchive();
    }
}
