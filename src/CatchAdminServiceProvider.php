<?php
namespace JaguarJack\CatchAdmin;

use App\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use JaguarJack\CatchAdmin\Console\BackupDatabase;
use JaguarJack\CatchAdmin\Console\CatchAdminInstall;
use JaguarJack\CatchAdmin\Console\CatchAdminUninstall;
use JaguarJack\CatchAdmin\Console\ImportData;

class CatchAdminServiceProvider extends ServiceProvider
{

    /**
     *
     * @time 2019年09月28日
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @return void
     */
    public function boot()
    {
        $this->loadApiRoute();

        $this->publish();

        $this->mergeAuth();

        $this->registerConsole();

        $this->registerMiddleware();
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
    protected function loadApiRoute()
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
    protected function publish()
    {
        $uploadConfig = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'upload.php';
        $adminConfig = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'catchAdmin.php';

        // 发布配置
        $this->publishes([
            $uploadConfig => config_path('upload.php'),
            $adminConfig  => config_path('catchAdmin.php'),
        ], 'catchConfig');

        // 发布 migration
        $this->publishes([
            dirname(__DIR__) .DIRECTORY_SEPARATOR. 'database' . DIRECTORY_SEPARATOR . 'migrations' =>
            base_path('database'. DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . 'catchAdmin'),
        ], 'catchMigration');

        // 发布 seed
        $this->publishes([
            dirname(__DIR__).DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'seed' =>
            base_path('database'.DIRECTORY_SEPARATOR.'seeds'.DIRECTORY_SEPARATOR.'catchAdmin')
        ], 'catchSeed');

    }

    /**
     * 合并 auth 认证
     *
     * @time 2019年09月26日
     * @return void
     */
    protected function mergeAuth()
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
    protected function registerExceptionHandle()
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
    protected function registerConsole()
    {
        $this->commands([
            BackupDatabase::class,
            CatchAdminInstall::class,
            CatchAdminUninstall::class,
            ImportData::class,
        ]);
    }

    /**
     * 注册中间件
     *
     * @time 2019年09月28日
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @return void
     */
    protected function registerMiddleware()
    {
        $middleware = config('catchAdmin.middleware');

        if (!empty($middleware)) {
            $router = $this->app['router'];

            foreach ($middleware['route'] as $alias => $m) {
                $router->aliasMiddleware($alias, $m);
            }

            $this->app->extend(Kernel::class, function ($service) use ($middleware) {
                return $service->prependMiddleware($middleware['catch.admin.cors']);
            });
        }
    }

}
