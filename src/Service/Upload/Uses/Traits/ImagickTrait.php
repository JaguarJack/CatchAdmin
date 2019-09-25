<?php
namespace JaguarJack\CatchAdmin\Service\Upload\Uses\Traits;

use Intervention\Image\Image;

trait ImagickTrait
{
    /**
     * 裁剪图片
     *
     * @time 2019年07月25日
     * @param $image
     * @return Image
     */
    protected function resize($image)
    {
        if (isset($this->params['width']) && isset($this->params['height'])) {

            $width = $this->params['width'] ? $this->params['width'] : config('upload.image.width');

            $height = $this->params['height'] ? $this->params['height'] : config('upload.image.height');

            return Image::make($image)->resize($width, $height)->save($image);
        }

        return $image;
    }

    /**
     * 添加水印
     *
     * @time 2019年07月25日
     * @param $image
     * @param $water
     * @return Image
     */
    protected function water($image)
    {
        if (isset($this->params['water']) && $this->params['water']) {

            $water = $this->params['water'] ? $this->params['water'] : config('upload.image.water');

            return Image::make($image)->insert($water);
        }

        return $image;
    }
}
