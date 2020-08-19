<?php

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * 命令行的名称及签名
     *
     * @var string
     */
    protected $signature = 'admin:install';

    /**
     * 命令行的描述
     *
     * @var string
     */
    protected $description = 'Install the admin package';

    /**
     * 执行命令行
     */
    public function handle()
    {
        $this->laravel['files']->makeDirectory("/Controllers/admin", 0755, true, true);
    }
}