<?php
namespace JaguarJack\CatchAdmin\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use JaguarJack\CatchAdmin\Exceptions\FailedException;

class DatabaseController extends Controller
{
    /**
     * 表列表
     *
     * @time 2019年09月26日
     * @param Request $request
     * @return array
     */
    public function tables(Request $request)
    {
        $tables = DB::select('show table status');

        foreach ($tables as &$table) {
            $table = array_change_key_case((array)$table, CASE_LOWER);
        }

        $page = $request->get('page');
        $limit = $request->get('limit');

        return $this->paginate((new LengthAwarePaginator(\array_slice($tables, ($page - 1) * $limit, $limit), \count($tables), $limit)));
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

        $columns = DB::select(sprintf('show full columns from %s', $table));

        foreach ($columns as &$column) {
            $column = array_change_key_case((array)$column);
        }

        return $this->success($columns);
    }

    /**
     * 修复表
     *
     * @time 2019年09月27日
     * @return void
     */
    public function repair()
    {

    }

    /**
     * 后台备份
     *
     * @time 2019年09月27日
     * @param Request $request
     * @return array
     */
    public function backup(Request $request)
    {
        try {
            $table = $request->post('table');

            Artisan::call('catch:backup', ['table' => $table]);
        } catch (\Exception $exception){
            throw new FailedException($exception->getMessage());
        }

        return $this->success();
    }
}
