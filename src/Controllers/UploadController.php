<?php
namespace JaguarJack\CatchAdmin\Controllers;

use JaguarJack\CatchAdmin\Service\Upload\UploadService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * 上传
     *
     * @time 2019年09月12日
     * @param Request $request
     * @param UploadService $uploadService
     * @return array
     */
    public function upload(Request $request, UploadService $uploadService): array
    {
        return $this->success($uploadService->upload($request->file('file')));
    }
}
