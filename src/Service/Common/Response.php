<?php
namespace JaguarJack\CatchAdmin\Service\Common;

use Illuminate\Contracts\Pagination\Paginator;

class Response
{
    /**
     * 成功返回
     *
     * @time 2019年10月08日
     * @param null $data
     * @param int $code
     * @param string $message
     * @return array
     */
    public function success($data = null, int $code = 20000, string $message = 'success')
    {
        return [
            'code'    => $code,
            'message' => $message,
            'data'    => $data
        ];
    }

    /**
     * 分页
     *
     * @time 2019年10月08日
     * @param Paginator $paginator
     * @return array
     */
    public function paginate(Paginator $paginator)
    {
        return $this->success([
            'list'         => $paginator->items(),
            'current_page' => $paginator->currentPage(),
            'total'        => $paginator->total(),
            'limit'        => $paginator->perPage(),
            'next'         => $paginator->currentPage() + 1
        ]);
    }
}
