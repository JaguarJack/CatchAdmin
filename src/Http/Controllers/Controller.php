<?php
namespace JaguarJack\CatchAdmin\Http\Controllers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use JaguarJack\CatchAdmin\Traits\AuthUserTrait;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, AuthUserTrait;

    /**
     * 成功返回
     *
     * @time 2019年09月10日
     * @param array $data
     * @param int $code
     * @param string $message
     * @return array
     */
    protected function success($data = null, int $code = 20000, string  $message = 'success'): array
    {
       return app('catchResponse')->success($data, $code, $message);
    }

    /**
     * 分页数据
     *
     * @time 2019年09月10日
     * @param Paginator $paginator
     * @return array
     */
    protected function paginate(Paginator $paginator): array
    {
       return app('catchResponse')->paginate($paginator);
    }
}
