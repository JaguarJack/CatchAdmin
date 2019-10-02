<?php

namespace JaguarJack\CatchAdmin\Models;

use JaguarJack\CatchAdmin\Traits\Db\CurdTrait;
use JaguarJack\CatchAdmin\Traits\Db\RegisterBuilderMethodTrait;
use JaguarJack\CatchAdmin\Traits\Db\TrainsTrait;
use JaguarJack\CatchAdmin\Traits\Permissions\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AdminUsers extends Authenticatable implements JWTSubject
{
    use Notifiable, CurdTrait, RegisterBuilderMethodTrait, TrainsTrait, HasRoles;

 	protected $table = 'admin_users';

    /**
     * 转换 unix 时间戳
     *
     * @var string
     */
    protected $dateFormat = 'U';

 	protected $fillable = [
		 'id',
		 'name',
		 'email',
		 'password',
		 'remember_token',
		 'created_at',
		 'updated_at'
 	 ];

    /**
     * 获取后台用户列表
     *
     * @time 2019年09月10日
     * @param $params
     * @return mixed
     */
 	public function getList($params)
    {
        return $this->select('id', 'name', 'avatar', 'email', 'created_at', 'updated_at')
                    ->when($params['name'] ?? false, function ($query) use ($params){
                        $query->whereLike('name', $params['name']);
                    })
                    ->when($params['email'] ?? false, function ($query) use ($params){
                        $query->whereLike('email', $params['email']);
                    })
                    ->paginate($params['limit'] ?? 10);
    }

    /**
     *
     * @time 2019年09月10日
     * @return mixed
     */
 	public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    /**
     *
     * @time 2019年09月10日
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }
}
