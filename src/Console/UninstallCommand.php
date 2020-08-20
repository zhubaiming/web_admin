<?php

namespace Toolman\Admin\Console;

use Illuminate\Console\Command;

class UninstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '删除后台包';

    protected $directory;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm('是否确认删除web_admin后台包？')) {
            $install_pwd = $this->secret('请输入安装密码进行删除');
            if ($install_pwd != '123456') {
                $this->error('安装密码错误，删除失败');
                exit(-1);
            } else {
                $this->info('删除即将开始');
                $this->output->progressStart(4);   // 创建进度条，n - 进度条步骤总数
                /*
                1、删除相关模型
                2、数据迁移回滚
                3、删除相关控制器
                 */
                $this->deleteAdminModels();
                $this->resetDatabase();
                $this->deleteAdminDirectory();

                $this->output->progressAdvance();
                $this->info('web_admin 后台包全部删除已完成，感谢您的使用！');
                $this->output->progressFinish();
            }
        } else {
            exit(0);
        }
    }

    public function deleteAdminModels()
    {
        $this->directory = config('admin.directory.model');

        if (is_dir($this->directory)) {
            $this->laravel['files']->deleteDirectory($this->directory);
            $this->output->progressAdvance();
            $this->info('模型删除已完成！');
        } else {
            $this->output->progressAdvance();
            $this->error('模型文件夹不存在');
        }
    }

    public function resetDatabase()
    {
        $this->call('migrate:reset');

        $this->output->progressAdvance();
        $this->info('数据迁移删除已完成！');
    }

    public function deleteAdminDirectory()
    {
        $this->directory = config('admin.directory.controller');

        if (is_dir($this->directory)) {
            $this->laravel['files']->deleteDirectory($this->directory);
            $this->output->progressAdvance();
            $this->info('控制器删除已完成！');
        } else {
            $this->output->progressAdvance();
            $this->error('控制器文件夹不存在');
//            exit(-1);
        }
    }
}
