<?php

use JaguarJack\CatchAdmin\Service\Upload\Uses\LocalUploadService;
use JaguarJack\CatchAdmin\Service\Upload\Uses\OssUploadService;
/**
 * 上传配置
 *
 */
return [
    /**
     * 文件配置
     */
    'file'     => [
        // 文件后缀
        'ext'             => ['zip', 'rar', 'txt', 'doc', 'pdf', 'xlsx', 'pptx', 'pptm', 'ppt', 'mp4'],
        // 文件上传目录
        // 'upload_dir'      => public_path('/uploads/files'),
        // 最大上传 20M
        'upload_max_size' => 1024 * 1024 * 20,
    ],

    /**
     * 图片
     */
    'image'    => [
        // 图片后缀
        'ext'             => ['gif', 'jpg', 'jpeg', 'png'],
        // 图片上传目录
        // 'upload_dir'      => public_path('/uploads/images'),
        // 最大上传 20M
        'upload_max_size' => 1024 * 1024 * 5,
        // 不限制图片宽度
        'width'           => '',
        // 默认不限制图片宽度
        'height'          => '',
        // 默认水印地址
        'qrcode'          => public_path('/uploads/images/qrcode.png'),
    ],

    /**
     * 驱动设置
     *
     * ['local', 'oss']
     *
     * 默认 oss => 阿里 OSS 服务
     */
    'driver'   => 'local',

    /**
     * 服务提供
     *
     *
     * 新的服务可以在这里添加
     */
    'provider' => [
        /**
         *  Oss 上传服务
         */
        'oss'   => OssUploadService::class,

        /**
         * 本地上传服务
         */
        'local' => LocalUploadService::class,
    ],

    // 第三方配置
    'config' => [
        // OSS 配置
        'oss' => [
            'access_key_id' => '',
            'access_secret' => '',
            'endpoint'      => '',
            'bucket'        => '',
        ]
    ],
];
