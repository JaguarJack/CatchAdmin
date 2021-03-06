<?php

namespace JaguarJack\CatchAdmin\Http\Requests\Article;

use JaguarJack\CatchAdmin\Http\Requests\FormRequest;

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
             'title'       => 'required|max:100',
             'content'     => 'required',
             'category_id' => 'required',
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
            'title'       => '标题',
            'content'     => '文章内容',
            'category_id' => '分类',
        ];
    }
}
