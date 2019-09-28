<?php
if (!function_exists('createTableTimestamps')) {
    function createTableTimestamps(\Illuminate\Database\Schema\Blueprint $table)
    {
        if (config('catchAdmin.model.unix_timestamp')) {
            $table->unsignedInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedInteger('updated_at')->default(0)->comment('更新时间');
        } else {
            $table->timestamps();
        }
    }
}
