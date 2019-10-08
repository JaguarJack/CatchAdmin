<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 *  非认证路由
 */

Route::namespace('JaguarJack\\CatchAdmin\\Http\\Controllers')->prefix('api/v1')->group(function () {
    Route::post('admin/login', 'LoginController@login');
});

/**
 * 认证路由
 */
Route::namespace('JaguarJack\\CatchAdmin\\Http\\Controllers')->middleware([
    'api',
    'catch.admin.auth:admin',
    'catch.admin.permission'
])->prefix('api/v1/admin')->group(function () {
    // 登录用户
    Route::get('user', 'LoginController@getUserInfo');
    Route::post('logout', 'LoginController@logout');

    // 后台用户路由
    Route::resource('users', 'AdminUsersController');
    Route::post('users/attach/roles', 'AdminUsersController@attachRoles');
    Route::get('users/get/roles/{user_id}', 'AdminUsersController@getRoles');

    // 角色路由
    Route::resource('roles', 'RolesController');
    Route::post('roles/attach/permissions', 'RolesController@attachPermissions');
    Route::get('roles/permissions/{role_id}', 'RolesController@getRolePermissions');
    Route::get('all/roles', 'RolesController@getRoles');

    // 权限路由
    Route::resource('permissions', 'PermissionsController');
    Route::get('routes', 'PermissionsController@getRouteList');

    // 上传
    Route::post('upload', 'UploadController@upload');

    /**
     * 前端待处理
     */
    // 表管理
    Route::get('tables', 'DatabaseController@tables');
    // 获取表结构
    Route::get('tables/structure/{tableName}', 'DatabaseController@tableStructure');
    // 备份表
    Route::post('tables/backup/{tableName}', 'DatabaseController@backup');
});

