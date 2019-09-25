<?php
namespace JaguarJack\CatchAdmin\Exceptions;

class LoginFailedException extends BaseException
{
    protected $message = '登录失败';

    protected $code = 210000;
}
