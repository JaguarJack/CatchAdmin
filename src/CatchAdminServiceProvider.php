<?php
namespace JaguarJack\CatchAdmin;

use Illuminate\Support\ServiceProvider;
use JaguarJack\CatchAdmin\Console\BackupDatabase;

class CatchAdminServiceProvider extends ServiceProvider
{

    /**
     *
     * @time 2019年09月25日
     * @return void
     */
    public function boot()
    {
        $this->loadApiRoute();

        $this->publishConfig();

        $this->mergeAuth();

        $this->registerConsole();
    }

    /**
     *
     * @time 2019年09月25日
     * @return void
     */
    public function register()
    {
        $this->registerExceptionHandle();
    }

    /**
     * 加载路由文件
     *
     * @time 2019年09月25日
     * @return void
     */
    public function loadApiRoute()
    {
        $routePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'admin.php';

        $this->loadRoutesFrom($routePath);
    }

    /**
     * 发布配置文件
     *
     * @time 2019年09月25日
     * @return void
     */
    public function publishConfig()
    {
        $uploadConfig = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'upload.php';
        $adminConfig = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'catchAdmin.php';

        $this->publishes([
            $uploadConfig => config_path('upload.php'),
            $adminConfig  => config_path('catchAdmin.php'),
        ]);
    }

    /**
     * 合并 auth 认证
     *
     * @time 2019年09月26日
     * @return void
     */
    public function mergeAuth()
    {
        $authConfig = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'auth.php';

        if (! $this->app->configurationIsCached()) {
            $this->app['config']->set('auth', array_merge_recursive(
                require $authConfig, $this->app['config']->get('auth', [])
            ));
        }
    }
    /**
     * register exception handle
     *
     * @time 2019年09月25日
     * @return void
     */
    public function registerExceptionHandle()
    {
        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \JaguarJack\CatchAdmin\Exceptions\Handler::class);
    }

    /**
     * 注册命令
     *
     * @time 2019年09月26日
     * @return void
     */
    public function registerConsole()
    {
        $this->commands([
            BackupDatabase::class,
        ]);
    }

}
