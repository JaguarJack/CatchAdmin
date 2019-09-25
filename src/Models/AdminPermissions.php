<?php

namespace JaguarJack\CatchAdmin\Models;

use JaguarJack\CatchAdmin\Observers\Db\PermissionsObservers;

class AdminPermissions extends BaseModel
{
 	protected $table = 'admin_permissions';

 	protected $fillable = [
		 'id',
		 'pid', // 父级ID
		 'name', // 菜单名称
         'level', // 层级
		 'alias', // 菜单别名
		 'route', // 路由名称
		 'method', // HTTP METHOD
		 'path', // 前端使用的路由路径
		 'created_at',
		 'updated_at'
 	 ];

    /**
     * register observer
     *
     * @var string
     */
 	protected static $observer = PermissionsObservers::class;

    /**
     * 获取菜单列表
     *
     * @time 2019年09月16日
     * @param $params
     * @return mixed
     */
 	public function getList($params)
    {
        $permissions = $this->select($this->fillable)
                            ->when($params['name'] ?? false, function ($query) use ($params) {
                                $query->whereLike('name', $params['name']);
                             })
                             ->when($params['method'] ?? false, function ($query) use ($params) {
                                $query->where('method', $params['method']);
                             })
                             ->get();

        // 搜索数据 需要父级数据
        if ($this->count() > $permissions->count()) {
            $levels = array_unique(explode('/', trim($permissions->pluck('level')->implode(''), '/')));

            $parentPermissions = $this->select($this->fillable)->whereIn('id', $levels)->get();

            return $permissions->merge($parentPermissions)->unique();
        }

        return $permissions;
    }

    /**
     * 获取全部
     *
     * @time 2019年09月17日
     * @return mixed
     */
    public function getAll()
    {
        return $this->select('id', 'pid', 'name')->get();
    }

    /**
     * 关联权限
     *
     * @time 2019年09月17日
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(AdminRoles::class, 'admin_role_has_permissions');
    }
 }
