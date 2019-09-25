<?php

namespace JaguarJack\CatchAdmin\Requests\Admin\AdminUsers;

use JaguarJack\CatchAdmin\Requests\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name'     => 'required|min:3|max:10',
            'password' => 'required|min:6',
            'email'    => 'required|email',
        ];
    }

    public function attributes()
    {
        return [
            'name'     => '用户名',
            'password' => '密码',
            'email'    => '邮箱',
        ];
    }
}
