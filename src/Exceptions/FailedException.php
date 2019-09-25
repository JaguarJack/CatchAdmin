<?php
namespace JaguarJack\CatchAdmin\Exceptions;

class FailedException extends BaseException
{
    protected $code = 403;

    protected $message = '失败';
}
