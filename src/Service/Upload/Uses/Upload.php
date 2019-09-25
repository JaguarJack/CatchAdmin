<?php

namespace JaguarJack\CatchAdmin\Service\Upload\Uses;


use JaguarJack\CatchAdmin\Exceptions\FailedException;
use JaguarJack\CatchAdmin\Service\Upload\Uses\Traits\Base64ImageTrait;
use JaguarJack\CatchAdmin\Service\Upload\Uses\Traits\ImagickTrait;
use JaguarJack\CatchAdmin\Service\Upload\Uses\Traits\UploadTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

abstract class Upload
{
    use UploadTrait, ImagickTrait, Base64ImageTrait;

    /**
     * uploadFile object
     *
     * @var UploadedFile
     */
    protected $file;

    /**
     * 上传参数
     *
     * @var array
     */
    protected $params;

    /**
     * 是否是多图
     *
     * @var bool
     */
    protected $multi = false;

    protected $uploadFileType;

    /**
     * 抽象方法
     *
     * @time 2019年07月25日
     * @return mixed
     */
    public abstract function upload();

    /**
     * 获取本地上图片路径|OSS上传路径
     *
     * @time 2019年07月25日
     * @throws \JaguarJack\CatchAdmin\Exceptions\FailedException
     */
    protected function dealBeforeUpload()
    {
        $this->checkExt();

        $this->checkSize();

        // 如果是上传图片资源的的话保存
        // 如果是由其他方式上传的图片路径就直接返回
        if (!$this->file instanceof UploadedFile) {
            return $this->file;
        }
        // 对于阿里的 OSS 而言 直接返回临时目录就行了
        if ($this instanceof OssUploadService) {
            return $this->file->getPathname();
        }

        return true;
    }

    /**
     * 获取方法
     *
     * @time 2019年07月29日
     * @return array
     * @throws FailedException
     */
    public function getUploadPath()
    {
        $method = $this->getUploadMethod();
        // 多图上传
        if ($this->multi) {
            $urls = [];
            // 建立临时变量
            $files = $this->file;
            foreach ($files as $file) {
                // 重新将多图的对象切换成单图对象
                $this->file = $file;
                $urls[] = $this->info($this->{$method}());
            }
            return $urls;
        } else {
            return $this->info($this->{$method}());
        }
    }

    /**
     * 生成文件名称
     *
     * @time 2019年07月26日
     * @param string $ext
     * @return string
     */
    protected function generateImageName(string $ext): string
    {
        return date('Y') . Str::random(10) . time() . '.' . $ext;
    }

    /**
     * 获取上传方法
     *
     * @time 2019年07月29日
     * @return string
     * @throws FailedException
     */
    protected function getUploadMethod()
    {
        $class = get_called_class();

        $service = explode('\\', $class);

        $className = array_pop($service);

        $method = lcfirst(str_replace('Service', '', $className));

        if (!method_exists($this, $method)) {
            throw new FailedException(sprintf('Method %s in Class %s Not Found~', $method, $class));
        }

        return $method;
    }

    /**
     * 获取信息
     *
     * @time 2019年07月29日
     * @return array
     */
    protected function info($path)
    {
        return [
            'path'         => $path,
            'ext'          => $this->getExtension(),
            'type'         => $this->getMimeType(),
            'size'         => $this->getUploadSize(),
            'originalName' => $this->getOriginName(),
        ];

    }

    /**
     * 参数设置
     *
     * @time 2019年07月25日
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->{$name} = $value;
    }

}
