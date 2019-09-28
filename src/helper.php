<?php
if (!function_exists('createTableTimestamps')) {
    /**
     * 创建
     *
     * @time 2019年09月29日
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param bool $softDelete
     * @return void
     */
    function createTableTimestamps(\Illuminate\Database\Schema\Blueprint $table, $softDelete = false)
    {
        if (config('catchAdmin.model.unix_timestamp')) {
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        } else {
            $table->timestamps();
        }

        if ($softDelete) {
            $table->softDeletes();
        }
    }
}
