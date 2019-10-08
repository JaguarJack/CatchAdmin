<?php

namespace JaguarJack\CatchAdmin\Http\Requests;

use JaguarJack\CatchAdmin\Exceptions\FailedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as BaseRequest;

abstract class FormRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 验证错误
     *
     * @time 2019年09月11日
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {

        $errors = $validator->getMessageBag()->getMessages();

        $error = array_shift($errors);

        throw new FailedException($error[0]);
    }
}
