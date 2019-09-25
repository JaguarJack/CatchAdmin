<?php
namespace JaguarJack\CatchAdmin\Traits\Permissions;

use JaguarJack\CatchAdmin\Models\AdminPermissions;
use JaguarJack\CatchAdmin\Models\AdminUsers;

trait HasPermissions
{
    /**
     * 角色关联用户
     *
     * @time 2019年09月17日
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(AdminUsers::class, 'admin_user_has_roles');
    }

    /**
     * 关联权限
     *
     * @time 2019年09月17日
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(AdminPermissions::class, 'admin_role_has_permissions', 'role_id', 'permission_id');
    }

    /**
     * 获取权限 IDs
     *
     * @time 2019年09月17日
     * @param $id
     * @return mixed
     */
    public function getPermissions($id)
    {
        return $this->findBy($id)->permissions()->get(['id']);
    }

    /**
     * 增加角色权限
     *
     * @time 2019年09月17日
     * @param $roleId
     * @param $permissionIds
     * @return void
     */
    public function attachPermissions($roleId, $permissionIds)
    {
        $this->findBy($roleId)->permissions()->attach($permissionIds);
    }


    public function detachPermissions($roleId)
    {
        $this->findBy($roleId)->permissions()->detach();
    }
}
