<?php

namespace JaguarJack\CatchAdmin\Requests\ArticleCategory;

use JaguarJack\CatchAdmin\Requests\FormRequest;

class UpdateRequest extends FormRequest
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
             'name' => 'required|max:10|unique:article_category,name,'.$this->route('articleCategory').',id'
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
