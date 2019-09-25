<?php
namespace JaguarJack\CatchAdmin\Service\Upload\Uses\Traits;

use JaguarJack\CatchAdmin\Exceptions\FailedException;

trait Base64ImageTrait
{
    protected $base64File;

    /**
     * 获取base文件后缀
     *
     * @time 2019年07月26日
     * @return mixed
     * @throws FailedException
     */
      protected function getBase64ImageExt()
      {
          // data:image/gif;base64,
          $res = preg_match('/^data.*?image\/(.*);\.*?base64.*?/', $this->base64File, $match);

          if (!$res) {
              throw new FailedException('base64文件格式错误，请重新上传');
          }

          return $match[1];
      }

    /**
     * 获取base文件大小
     *
     * @time 2019年07月26日
     * @return int
     */
      protected function getBase64ImageSize()
      {
          // 粗略计算大小
          return strlen($this->base64File);
      }

    /**
     * 获取base64图片路径
     *
     * @time 2019年07月26日
     * @return string
     * @throws FailedException
     */
      protected function getBase64FilePath()
      {
          $path = $this->getUploadDir() . '/'. $this->generateImageName($this->getBase64ImageExt());
          // 截取图片资源
          $image = substr($this->base64File, strpos($this->base64File, ',') + 1);
          // 生成图片
          if (file_put_contents($path, base64_decode($image))) {
              return $path;
          }

          throw new FailedException('上传base64图片失败');
      }

}
