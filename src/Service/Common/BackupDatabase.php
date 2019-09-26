<?php
namespace JaguarJack\CatchAdmin\Service\Common;

use Illuminate\Database\Eloquent\Model;

class BackupDatabase
{
    protected $table;

    protected $backPath;

    /**
     * 生成
     *
     * @time 2019年09月27日
     * @param $tables
     * @return void
     */
    public function generator($tables)
    {
        $backup = config('catchAdmin.backup');

        $this->backPath = $backup['path'] . $backup['format'] . DIRECTORY_SEPARATOR;

        foreach ($tables as $table) {
            $this->table = $table;

            $this->createDataFile($backup['format']);
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
            fwrite($handle, $begin = "<?php \r\n return array(\r\n", \strlen($begin));
            $this->createClass($this->table, $format, $handle);
            fwrite($handle, $end = "\r\n );", \strlen($end));
        } else {
            fwrite($handle, $begin = "BEGIN;\r\n", \strlen($begin));
            $this->createClass($this->table, $format, $handle);
            fwrite($handle, $end = 'COMMIT;', \strlen($end));
        }

        fclose($handle);
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
        $data = var_export($data, true) . ',';

        fwrite($handle, $data, strlen($data));
    }

    /**
     * sql 文件格式
     *
     * @time 2019年09月27日
     * @param $handle
     * @param $data
     * @return void
     */
    protected function sqlFormat($handle, $data)
    {
        $insertSql = sprintf('INSERT INTO `%s` VALUE (%s)' . "\r\n", $this->table, trim(implode(',', $data), ','));

        fwrite($handle, $insertSql, strlen($insertSql));
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
        (new class($table) extends Model {
            public function __construct($table, array $attributes = [])
            {
                parent::__construct($attributes);

                $this->table = $table;
            }
        })->cursor()->each(function ($item, $key) use ($format, $handle){
                $this->{$format.'Format'}($handle, $item->toArray());
        });
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
}
