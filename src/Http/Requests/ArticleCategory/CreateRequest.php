<?php

namespace JaguarJack\CatchAdmin\Http\Requests\ArticleCategory;

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
             'name' => 'required|max:10'
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
             'name' => '分类名称'
		 ];
	 }
}
