<?php
namespace JaguarJack\CatchAdmin\Traits\Db;

use Illuminate\Database\Query\Builder;

trait RegisterBuilderMethodTrait
{
    public static function bootRegisterBuilderMethodTrait()
    {
        static::whereLike();
    }

    /**
     * 自定义 like 方法
     *
     * @time 2019年07月15日
     */
    private static function whereLike()
    {
        Builder::macro('whereLike', function ($field, $value){
                return $this->where($field, 'like', "%{$value}%");
        });
    }
}
