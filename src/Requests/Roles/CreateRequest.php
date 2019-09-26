<?php

namespace JaguarJack\CatchAdmin\Requests\Roles;

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
             'name' => 'required|min:3|max:10|unique:admin_roles,name,'.$this->route('role'),
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
             'name' => '角色名称'
		 ];
	 }
}
