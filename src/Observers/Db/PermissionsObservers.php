<?php

namespace JaguarJack\CatchAdmin\Observers\Db;

use JaguarJack\CatchAdmin\Exceptions\FailedException;
use JaguarJack\CatchAdmin\Models\AdminPermissions;

class PermissionsObservers
{
    //
    /**
     * created
     *
     * @time 2019年09月17日
     * @param AdminPermissions $permissions
     * @return void
     */
    public function created(AdminPermissions $permissions)
    {
        if ($permissions->pid) {
            $parent = $permissions->where('id', $permissions->pid)->first();

            $permissions->level = $parent->level . '/' . $permissions->pid;

            $permissions->save();
        }
    }

    /**
     * delete
     *
     * @time 2019年09月17日
     * @param AdminPermissions $permissions
     * @return void
     */
    public function deleting(AdminPermissions $permissions)
    {
        if ($permissions->where('pid', $permissions->id)->first()) {
            throw new FailedException('该菜单下有子级菜单');
        }
    }
}
