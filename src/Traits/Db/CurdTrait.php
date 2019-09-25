<?php

namespace JaguarJack\CatchAdmin\Traits\Db;

use JaguarJack\CatchAdmin\Exceptions\FailedException;
use Illuminate\Support\Str;

/**
 * 数据库基本操作
 * Trait CurdTrait
 * @package JaguarJack\CatchAdmin\Traits\DB
 */
trait CurdTrait
{
    /**
     * create
     *
     * @time 2019年03月19日
     * @param array $data
     * @return mixed
     */
    public function store(array $data)
    {
        // 循环使用 save 方法 需要重新生成模型对象 所以这里直接使用新对象使用
        $newInstance = static::newInstance($this->fillable);

        foreach ($data as $attr => $value) {
            if (in_array($attr, $this->fillable)) {
                $newInstance->{$attr} = $value;
            }
        }

        if ($newInstance->save()) {
            return $newInstance->id;
        }

        return false;
    }

    /**
     * update
     *
     * @time 2019年03月19日
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws
     */
    public function updateBy(int $id, array $data)
    {
        $info = $this->findBy($id);

        if (!$info) {
            return false;
        }

        $fillable = array_diff($this->fillable, [self::CREATED_AT, self::UPDATED_AT]);

        foreach ($data as $attr => $value) {
            if (in_array($attr, $fillable) && $value) {
                $info->{$attr} = $value;
            }
        }

        return $info->save();
    }

    /**
     * find by id
     *
     * @time 2019年03月19日
     * @param int $id
     * @param array $column
     * @return mixed
     */
    public function findBy(int $id, $column = ['*'])
    {
        return self::where($this->getPrimaryKey(), $id)->first($column);
    }

    /**
     * delete by id  支持单条删除 及 多条删除
     * 格式支持 2  [2,3]  2,3
     * @time 2019年03月19日
     * @param int $id
     * @return mixed
     */
    public function deleteBy($id)
    {
        if (is_array($id)) {
            return self::whereIn($this->getPrimaryKey(), array_filter($id))->delete();
        }

        if (strpos($id, ',')) {
            return self::whereIn($this->getPrimaryKey(), array_filter(explode(',', $id)))->delete();
        }

        return self::destroy($id);
    }

    /**
     * 获取 primarykey
     *
     * @time 2019年08月21日
     * @return mixed
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * 获取table
     *
     * @time 2019年08月21日
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    public static function boot()
    {
        parent::boot();

        if (property_exists(static::class, 'observer')) {
            static::observe(static::$observer);
        }
    }
}
