<?php

namespace JaguarJack\CatchAdmin\Http\Requests\AdminPermissions;

use JaguarJack\CatchAdmin\Http\Requests\FormRequest;

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
             'name'   => 'required|min:3|max:8|unique:admin_permissions,name',
             'route'  => $this->request->get('pid') ? 'required|regex:/[a-zA-Z]+\.[a-zA-Z]+$/|unique:admin_permissions,route' : 'sometimes',
             'method' => 'required|in:get,post,put,delete',
             'path'   => 'required|unique:admin_permissions,path',
		 ];
	 }
	 /**
	   * reset attributes.
	   *
	   * @return array
	   */
	 public function attributes()
	 {
		 return [
		   //
             'name'   => '菜单名称',
             'route'  => '路由名称',
             'method' => '请求方法',
             'path'   => '前端路径',
		 ];
	 }
}
