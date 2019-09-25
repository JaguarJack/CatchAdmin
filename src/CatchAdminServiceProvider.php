<?php
namespace JaguarJack\CatchAdmin;

use Illuminate\Support\ServiceProvider;

class CatchAdminServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadApiRoute();

        $this->registerExceptionHandle();
    }

    public function register()
    {
        $this->publishConfig();
    }

    public function loadApiRoute()
    {
        $routePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'admin.php';

        $this->loadRoutesFrom($routePath);
    }


    public function publishConfig()
    {
        $uploadConfig = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'upload.php';

        $this->publishes([
            $uploadConfig => config_path('upload.php'),
        ]);
    }

    public function registerExceptionHandle()
    {
        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \JaguarJack\CatchAdmin\Exceptions\Handler::class);
    }

}
