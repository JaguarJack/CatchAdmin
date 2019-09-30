<?php
namespace JaguarJack\CatchAdmin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data {--table=} {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import data';

    protected $path;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $table = $this->option('table');

        $this->path = $this->option('path') ? : config('catchAdmin.backup.path') . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR;

        if ($table) {
            $this->importInputTable($table);
        } else {
            $this->importAll();
        }
    }

    /**
     * 导入单张表
     *
     * @time 2019年09月30日
     * @param $table
     * @return void
     */
    protected function importInputTable($table)
    {
        if (!in_array($table, $this->getTables())) {
            $this->error('表 %s 没有导出数据', $table);exit;
        }

        $file = $this->path . $table . '.php';

        $this->insert($file, $table);
    }

    /**
     * 导入全部
     *
     * @time 2019年09月30日
     * @return void
     */
    protected function importAll()
    {
        foreach ($this->getTables() as $table) {
            $this->importInputTable($table);
        }
    }

    /**
     * 插入数据
     *
     * @time 2019年09月30日
     * @param $file
     * @param $table
     * @return void
     */
    protected function insert($file, $table)
    {
        foreach ($this->readFromFileByYield($file) as $line) {
            $line = rtrim($line, "\r\n");
            if (strtolower($line) == 'begin') {
                continue;
            }

            $this->insertData($table, $this->parseLine($line));
        }
    }

    /**
     * 获取表
     *
     * @time 2019年09月30日
     * @return array
     */
    protected function getTables()
    {
        $tables = [];

        foreach (glob($this->path . '*.php') as $file) {
            $tables[] = pathinfo($file, PATHINFO_FILENAME);
        }

        return $tables;
    }

    /**
     * 读取文件
     *
     * @time 2019年09月30日
     * @param $file
     * @return \Generator
     */
    protected function readFromFileByYield($file)
    {
        $handle = fopen($file, 'rb+');

        while (!feof($handle)) {
            yield fgets($handle);
        }

        fclose($handle);
    }

    /**
     *
     * @time 2019年09月30日
     * @param $line
     * @return mixed
     */
    protected function parseLine($line)
    {
        $line = base64_decode($line);

        return unserialize($line);
    }

    /**
     * 导出数据
     *
     * @time 2019年09月30日
     * @param $table
     * @param $data
     * @return void
     */
    protected function insertData($table, $data) {
        DB::table($table)->insert($data);
    }
}
