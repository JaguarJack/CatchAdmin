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
namespace JaguarJack\CatchAdmin\Service\Upload;

use JaguarJack\CatchAdmin\Exceptions\FailedException;

/**
 * Class UploadService
 * Date 2019-07-29
 * @package JaguarJack\CatchAdmin\Service\Upload
 *
 * 如何扩展 以 七牛为例
 * 1.在 uses 新增 QiNiuUploadService
 * 2.实现 upload 方法
 * 3.自定义实现 QiQiuUpload 方法 这个方法真正上传的方法 里面实现相对应的上传逻辑就可以了
 * 4.配置文件 upload 自定义 driver 例如 qiniu
 * 5.配置文件 upload 增加 provider => ['qiniu' => QiNiuUploadService::class]
 */

class UploadService
{
    /**
     * 设置驱动
     *
     * @var string
     */
    protected $driver = '';

    /**
     * 设置参数
     *
     * @var array
     */
    protected $params;

    /**
     * 上传
     *
     * @time 2019年07月29日
     * @param $file
     * @return mixed
     * @throws FailedException
     */
    public function upload($file)
    {
        // 解析图片上传服务
        $driver = $this->makeProvider();
        // 设置图片对象
        $driver->file = $file;
        // 设置多图
        $driver->multi = $this->isMulti($file);
        // 设置上传参数
        $driver->params = $this->params;
        // 上传
        return $driver->upload();
    }

    /**
     * 设置参数
     *
     * @time 2019年07月25日
     * @param $params
     * @return $this
     */
    public function setParams($params)
    {
        // TODO: Implement __set() method.
        $this->params = $params;

        return $this;
    }

    /**
     * 设置驱动
     *
     * @time 2019年07月29日
     * @param $driver
     * @return $this
     */
    public function driver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * 创建 Driver
     *
     * @time 2019年07月29日
     * @return string
     */
    protected function createDriver()
    {
        return $this->driver ? : config('upload.driver');
    }

    /**
     * 创建服务
     *
     * @time 2019年07月29日
     * @return mixed
     * @throws FailedException
     */
    protected function makeProvider()
    {
        $driver = $this->createDriver();

        $provider = config('upload.provider.'.$driver);

        if (!$provider) {
            throw new FailedException(sprintf('未提供该上传服务【%s】', $driver));
        }

        return app()->make($provider);
    }


    /**
     * 是否是多图
     *
     * @time 2019年07月29日
     * @param $file
     * @return bool
     */
    protected function isMulti($file)
    {
        return is_array($file) ? true : false;
    }
}
