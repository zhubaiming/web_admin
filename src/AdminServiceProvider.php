<?php

namespace Toolman\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    protected $commands = [
        Console\AdminCommand::class,
        Console\InstallCommand::class,
        Console\UninstallCommand::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
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
            __DIR__ . '/../config/admin.php' => config_path('admin.php'),  // 发布配置文件到 laravel 的 config 下
            __DIR__ . '/../database/migrations/' => base_path('database/migrations/'),
            __DIR__ . '/../resources/views/' => base_path('resources/views/admin/'),   // 发布视图目录到 resources 下
            __DIR__ . '/../resources/lang/' => base_path('resources/lang/'),
            __DIR__ . '/../routes/' => base_path('routes/'),
        ]);
    }
}
