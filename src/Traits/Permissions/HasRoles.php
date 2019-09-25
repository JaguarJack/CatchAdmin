<?php
namespace JaguarJack\CatchAdmin\Traits\Permissions;

use JaguarJack\CatchAdmin\Models\AdminRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRoles
{
    /**
     * 关联角色
     *
     * @time 2019年09月17日
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(AdminRoles::class, 'admin_user_has_roles', 'user_id', 'role_id');
    }

    /**
     * 获取角色
     *
     * @time 2019年09月17日
     * @param $userId
     * @param array $field
     * @return mixed
     */
    public function getRoles($userId, $field = ['id', 'name'])
    {
        return $this->findBy($userId)->roles()->get($field);
    }

    /**
     * 新增角色
     *
     * @time 2019年09月17日
     * @param $userId
     * @param $roles
     * @return void
     */
    public function attachRoles($userId, $roles): void
    {
        $this->findBy($userId)->roles()->attach($roles);
    }

    /**
     * 删除角色
     *
     * @time 2019年09月17日
     * @param $userId
     * @return void
     */
    public function detachRoles($userId): void
    {
        $user = $this->findBy($userId);

        $roles = $user->roles()->pluck('id')->toArray();

        $this->findBy($userId)->roles()->detach($roles);
    }
}
