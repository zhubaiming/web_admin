<?php

namespace Aex\Packagetest;

use Illuminate\Support\ServiceProvider;

class PackagetestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // 单例绑定服务
        $this->app->singleton('packagetest', function ($app) {
            return new Packagetest($app['session'], $app['config']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'Packagetest');    // 视图目录指定

        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/packagetest'),  // 发布视图目录到 resources 下
            __DIR__ . '/config/packagetest.php' => config_path('packagetest.php'),  // 发布配置文件到 laravel 的 config 下
        ]);
    }
}
