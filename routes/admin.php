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
Route::namespace('JaguarJack\\CatchAdmin\\Controllers')->prefix('api/v1')->group(function () {
    Route::post('admin/login', 'LoginController@login');
});

/**
 * 认证路由
 */
Route::namespace('JaguarJack\\CatchAdmin\\Controllers')->middleware([
    'api',
    'check.auth:admin',
    'check.permission'
])->prefix('api/v1')->group(function () {
    // 登录用户
    Route::get('admin/user', 'LoginController@getUserInfo');
    Route::post('admin/logout', 'LoginController@logout');

    // 后台用户路由
    Route::resource('admin/users', 'AdminUsersController');
    Route::post('admin/users/attach/roles', 'AdminUsersController@attachRoles');
    Route::get('admin/users/get/roles/{user_id}', 'AdminUsersController@getRoles');

    // 角色路由
    Route::resource('admin/roles', 'RolesController');
    Route::post('admin/roles/attach/permissions', 'RolesController@attachPermissions');
    Route::get('admin/roles/permissions/{role_id}', 'RolesController@getRolePermissions');
    Route::get('admin/all/roles', 'RolesController@getRoles');

    // 权限路由
    Route::resource('admin/permissions', 'PermissionsController');

    // 上传
    Route::post('admin/upload', 'UploadController@upload');
});

