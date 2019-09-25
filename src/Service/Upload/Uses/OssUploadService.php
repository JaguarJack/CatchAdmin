<?php
/* *********************************************************************************************************
 *百家云 _ _     _ _
    /  _ _  \   \  \
  /  /     \  \   \  \    项目所有权解释权归百家云公司所有
 |  |  / \   \__\ /  /    非百家云授权的使用项目代码违法必究
  \  \ \   \ ____/  /
    \__\ \_ _ __ _/                                           ------------ 南京百家云公司所有
 ________  ________  ___            ___  ___  ________           ___    ___ ___  ___  ________
|\   __  \|\   __  \|\  \          |\  \|\  \|\   __  \         |\  \  /  /|\  \|\  \|\   ___\
\ \  \|\ /\ \  \|\  \ \  \          \ \  \ \  \ \  \|\  \        \ \  \/  / | \  \\\  \ \  \\ \  \
 \ \   __  \ \   __  \ \  \       __ \ \  \ \  \ \   __  \        \ \    / / \ \  \\\  \ \  \\ \  \
  \ \  \|\  \ \  \ \  \ \  \     |\  \\_\  \ \  \ \  \ \  \        \/  /  /   \ \  \\\  \ \  \\ \  \
   \ \_______\ \__\ \__\ \__\    \ \________\ \__\ \__\ \__\     __/  / /      \ \_______\ \__\\ \__\
    \|_______|\|__|\|__|\|__|     \|________|\|__|\|__|\|__|    |\___/ /        \|_______|\|__| \|__|
                                                                \|___|/
 *********************************************************************************************************
 */
namespace JaguarJack\CatchAdmin\Service\Upload\Uses;

use JaguarJack\CatchAdmin\Exceptions\FailedException;
use Illuminate\Support\Facades\Log;
use OSS\OssClient;

class OssUploadService extends Upload
{

    protected $bucket;

    protected $ossClient;

    /**
     * 初始化
     *
     * OssUploadService constructor.
     * @throws \OSS\Core\OssException
     */
    public function __construct()
    {
        list($ossKey, $ossSecret, $endPoint, $this->bucket) = $this->aliOssConfig();

        $this->ossClient = new OssClient($ossKey, $ossSecret, $endPoint);
    }

    /**
     * 上传
     *
     * @time 2019年07月25日
     * @return mixed|void
     * @throws FailedException
     */
    public function upload()
    {
        try {
            return $this->getUploadPath();
        } catch (\Exception $e) {
            Log::error(sprintf('Oss 上传失败: %s', $e->getMessage()));
            throw new FailedException($e->getMessage());
        }
    }

    /**
     * oss 上传
     *
     * @time 2019年07月29日
     * @return mixed
     * @throws FailedException
     * @throws \OSS\Core\OssException
     */
    protected function ossUpload()
    {
        $path = $this->dealBeforeUpload();

        $ossFileName = $this->createUploadDir() . $this->isFileExist($this->getOssFileName());

        $response = $this->ossClient->uploadFile($this->bucket, $ossFileName, $path);

        if (!$response || !isset($response['info'])) {
            throw new FailedException('上传失败，请重新上传');
        }
        return $response['info']['url'];
    }


    /**
     * 创建 bucket
     *
     * @time 2019年07月25日
     */
    protected function getOssFileName()
    {
        return $this->generateImageName($this->getExtension());
    }

    /**
     * 检查文件是否存在
     *
     * @time 2019年07月25日
     * @param $ossFileName
     * @return string
     */
    protected function isFileExist($ossFileName)
    {
        if ($this->ossClient->doesObjectExist($this->bucket, $ossFileName)) {
            $ossFileName = $this->getOssFileName();
            return $this->isFileExist($ossFileName);
        }

        return $ossFileName;
    }

    /**
     * 获取 OSS client
     *
     * @time 2019年07月25日
     * @return array
     */
    protected function aliOssConfig()
    {
        $ossConfig = config('upload.config.oss');

        return [
            $ossConfig['access_key_id'], $ossConfig['access_secret'], $ossConfig['endpoint'], $ossConfig['bucket'],
        ];
    }

    /**
     * 创建上传目录
     *
     * @time 2019年07月25日
     * @return string
     */
    protected function createUploadDir()
    {
        $uploadDir = 'uploads/%s/';

        return sprintf($uploadDir, $this->getMimeType());
    }
}
