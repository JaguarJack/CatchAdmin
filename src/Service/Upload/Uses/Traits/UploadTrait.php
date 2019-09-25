<?php
namespace JaguarJack\CatchAdmin\Service\Upload\Uses\Traits;

use JaguarJack\CatchAdmin\Exceptions\FailedException;
use Illuminate\Http\UploadedFile;

trait  UploadTrait
{
    /**
     * 检查上传图片的后缀
     *
     * @time 2019年07月25日
     * @throws FailedException
     */
    protected function checkExt()
    {
        $extensions = config(sprintf('upload.%s.ext', $this->getMimeType()));

        $fileExt = $this->getExtension();

        if (!in_array($fileExt, $extensions)) {
            throw new FailedException(sprintf('不支持该上传该文件类型(%s)类型', $fileExt));
        }
    }

    /**
     * 检测上传文件的后缀
     *
     * @time 2019年07月25日
     * @throws FailedException
     */
    protected function checkSize()
    {
        $size = config(sprintf('upload.%s.upload_max_size', $this->getMimeType()));

        if ($this->getUploadSize() > $size) {
            throw new FailedException('超过文件最大支持的大小');
        }
    }

    /**
     * 获取上传路径
     *
     * @time 2019年07月25日
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getUploadDir()
    {
        $storePath = 'uploads' . DIRECTORY_SEPARATOR . $this->getMimeType() . DIRECTORY_SEPARATOR . date('Y-m-d', time());

        return $storePath;
    }

    /**
     * 获取配置
     *
     * @time 2019年07月25日
     * @return string
     */
    protected function getMimeType()
    {
        if ($this->isBase64File()) {
            return 'image';
        }

        // 图片上传
        if ($this->file instanceof UploadedFile) {
            $type = explode('/', $this->file->getClientMimeType());
            return $type[0] == 'image' ? 'image' : 'file';
        }

        // 直传文件
        return in_array($this->getExtension(), config('upload.image.ext')) ? 'image' : 'file';

    }

    /**
     * 是否是 base64 格式
     *
     * @time 2019年07月26日
     */
    protected function isBase64File()
    {
        if (isset($this->params['base64_image']) && $this->params['base64_image']) {
            $this->base64File = $this->params['base64_image'];
            return true;
        }
        return false;
    }

    /**
     * 获取扩展
     *
     * @time 2019年07月26日
     * @return mixed
     */
    protected function getExtension()
    {
        if ($this->isBase64File()) {
            return strtolower($this->getBase64ImageExt());
        }

        if ($this->file instanceof UploadedFile) {
            return strtolower($this->file->getClientOriginalExtension());
        }

        // 直传文件
        return pathinfo($this->file, PATHINFO_EXTENSION);
    }

    /**
     * 获取上传图片/文件大小
     *
     * @time 2019年07月26日
     * @return mixed
     */
    protected function getUploadSize()
    {
        if ($this->isBase64File()) {
            return $this->getBase64ImageSize();
        }

        if ($this->file instanceof UploadedFile) {
            return $this->file->getSize();
        }
        // 直传文件为零
        return 0;
    }

    /**
     * 获取图片原始名称
     *
     * @time 2019年07月30日
     * @return string|null
     */
    public function getOriginName()
    {
        // 上传图片获取
        if ($this->file instanceof UploadedFile) {
            return $this->file->getClientOriginalName();
        }
        // 其他情况返回空
        return '';
    }
}
