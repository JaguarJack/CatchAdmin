<?php
namespace JaguarJack\CatchAdmin\Traits\Db;

use Illuminate\Support\Facades\DB;

/**
 * 事物操作
 * Trait TrainsTrait
 * @package JaguarJack\CatchAdmin\Traits\DB
 */
trait TrainsTrait
{
    /**
     * 事务开启
     *
     * @time 2019年03月19日
     * @email wuyanwen@baijiayun.com
     */
    public function beginTransaction()
    {
        DB::beginTransaction();
    }

    /**
     * 事务回滚
     *
     * @time 2019年03月19日
     * @email wuyanwen@baijiayun.com
     */
    public function rollback()
    {
        DB::rollback();
    }

    /**
     * 事务提交
     *
     * @time 2019年03月19日
     * @email wuyanwen@baijiayun.com
     */
    public function commit()
    {
        DB::commit();
    }

    /**
     * 执行一组事务操作
     *
     * @time 2019年03月19日
     * @email wuyanwen@baijiayun.com
     * @param \Closure $callback
     */
    public function transaction(\Closure $callback)
    {
        DB::transaction($callback());
    }

    /**
     *
     *
     * @time 2019年05月24日
     * @email wuyanwen@baijiayun.com
     * @param $sql
     * @return mixed
     */
    public function raw($sql)
    {
        return DB::raw($sql);
    }
}
