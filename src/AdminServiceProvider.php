<?php

namespace Poolbear\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    // 命令白名单
    protected $commands = [
        Console\InstallCommand::class
    ];

    public function register()
    {
        $this->commands($this->commands);
    }
}