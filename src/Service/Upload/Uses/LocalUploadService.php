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

class LocalUploadService extends Upload
{
    /**
     * 上传
     *
     * @time 2019年07月25日
     * @return mixed|void
     * @throws FailedException
     */
    public function upload()
    {
        if ($this->multi) {
            return $this->multi($this->getUploadPath());
        }

        return $this->addUrl($this->getUploadPath());
    }

    /**
     * 处理多图
     *
     * @time 2019年07月29日
     * @param $pathes
     * @return mixed
     */
    protected function multi($pathes)
    {
        foreach ($pathes as &$path) {
            $path = $this->addUrl($path);
        }

        return $pathes;
    }

    /**
     * 切换 URL
     *
     * @time 2019年07月29日
     * @param $path
     * @return string
     */
    protected function addUrl($path)
    {
        $path['path'] = config('app.url') .  $path['path'];

        return $path;
    }

    /**
     * 本地上传
     *
     * @time 2019年07月29日
     * @return \Intervention\Image\Image
     * @throws FailedException
     */
    protected function localUpload()
    {
        if ($this->isBase64File()) {
            $path = $this->getBase64FilePath();
        } else {
            $path = $this->file->store($this->getUploadDir());
        }

        return $this->water($this->resize($path));
    }
}
