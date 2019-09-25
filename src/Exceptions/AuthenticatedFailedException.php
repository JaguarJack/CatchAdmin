<?php
namespace JaguarJack\CatchAdmin\Exceptions;

class AuthenticatedFailedException extends BaseException
{
    protected $code = 210000;

    protected $message = '登录失效';
}
