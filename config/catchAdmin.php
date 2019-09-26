<?php
return [

    /**
     * 模型设置
     *
     */
    'model' => [
        /**
         *  设置 unix 时间错
         */
        'unix_timestamp' => true,

        /**
         * 设置每页数量
         *
         */
        'page_limit'     => 10
    ],

    /**
     * 数据库备份
     *
     */
    'backup' => [
        /**
         * 数据备份格式
         *  sql => sql 文件
         *  php => php 数组文件
         */
        'format' => 'sql',

        // 备份位置
        'path'   => base_path('database' . DIRECTORY_SEPARATOR . 'backup' . DIRECTORY_SEPARATOR),

        // 默认启用内存
        'backup_memory' => '256M',
    ],
];
