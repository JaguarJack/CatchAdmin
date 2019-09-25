<?php
namespace JaguarJack\CatchAdmin\Controllers;

use JaguarJack\CatchAdmin\Exceptions\LoginFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * 后台登录
     *
     * @time 2019年09月10日
     * @param Request $request
     * @return array
     * @throws LoginFailedException
     */
    public function login(Request $request): array
    {
        $token = Auth::guard('admin')->attempt([
            'name'     => $request->post('username'),
            'password' => $request->post('password'),
        ]);

        if (!$token) {
            throw new LoginFailedException();
        }

        $user = Auth::guard('admin')->user();

        $user->remember_token = $token;

        $user->save();

        return $this->success($token);
    }

    /**
     * 获取用户信息
     *
     * @time 2019年09月10日
     * @return array
     */
    public function getUserInfo()
    {
        $loginUser = $this->getLoginUser();

        return $this->success([
            'name'         => $loginUser->name,
            'avatar'       => $loginUser->avatar,
            'introduction' => $loginUser->introduction,
        ]);
    }

    /**
     * 登出
     *
     * @time 2019年09月10日
     * @return mixed
     */
    public function logout()
    {
        return parent::logout();
    }
}
