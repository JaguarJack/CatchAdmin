<?php
namespace JaguarJack\CatchAdmin\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class BaseException extends HttpException
{
    protected $code = 0;

    public function __construct(string $message = '', ?int $code = 0, int $statusCode = 200)
    {
        parent::__construct($statusCode, $message ? : $this->message, null, [], $this->code);

    }
}
