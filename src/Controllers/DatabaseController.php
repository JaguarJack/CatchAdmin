<?php
namespace JaguarJack\CatchAdmin\Controllers;


use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    /**
     * 表列表
     *
     * @time 2019年09月26日
     * @return array
     */
    public function tables()
    {
        $tables = DB::select('show table status');

        foreach ($tables as &$table) {
            $table = array_change_key_case((array)$table, CASE_LOWER);
        }

        return $this->success($tables);
    }

    /**
     * 表结构
     *
     * @time 2019年09月26日
     * @param $table
     * @return array
     */
    public function tableStructure($table)
    {
        $columns = DB::getDoctrineSchemaManager()->listTableDetails($table)->getColumns();

        foreach ($columns as &$column) {
            $type = $column->getType()->getName();
            $column = $column->toArray();
            $column['type'] = $type;

        }

        return $this->success($columns);
    }

    public function repair()
    {

    }

    public function backup()
    {

    }
}
