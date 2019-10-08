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
        return [
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ];
    }

    /**
     * 分页数据
     *
     * @time 2019年09月10日
     * @param array $data
     * @return array
     */
    protected function paginate(Paginator $data): array
    {
        $data = [
            'list'         => $data->items(),
            'current_page' => $data->currentPage(),
            'total'        => $data->total(),
            'limit'        => $data->perPage(),
            'next'         => $data->currentPage() + 1,
        ];

        return $this->success($data);
    }
}
