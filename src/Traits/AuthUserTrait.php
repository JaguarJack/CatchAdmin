<?php
namespace JaguarJack\CatchAdmin\Traits;

use Illuminate\Support\Facades\Auth;

trait AuthUserTrait
{
    /**
     * 获取登录用户信息
     *
     * @time 2019年09月10日
     * @return mixed
     */
    protected function getLoginUser()
    {
        $guard = app('request')->guard;

        return Auth::guard($guard)->user();
    }

    /**
     * 获取登录用户ID
     *
     * @time 2019年09月10日
     * @return mixed
     */
    protected function getLoginUserId()
    {
        return $this->getLoginUser()->id;
    }

    /**
     * 登出
     *
     * @time 2019年09月10日
     * @return mixed
     */
    protected function logout()
    {
        return Auth::guard(app('request')->guard)->logout();
    }
}
