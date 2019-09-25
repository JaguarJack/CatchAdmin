<?php

namespace JaguarJack\CatchAdmin\Models;

use JaguarJack\CatchAdmin\Traits\Permissions\HasPermissions;

class AdminRoles extends BaseModel
{
    use HasPermissions;

 	protected $table = 'admin_roles';

 	protected $fillable = [
		 'id',
		 'name',
		 'created_at',
		 'updated_at'
 	 ];

    /**
     * get list
     *
     * @param $params
     * @return mixed
     */
 	public function getList($params)
    {
        return $this->select('id', 'name', 'created_at', 'updated_at')
                    ->when($params['name'] ?? false, function ($query) use ($params){
                        $query->whereLike('name', $params['name']);
                    })->paginate($paramsp['limit'] ?? $this->limit);
    }
 }
