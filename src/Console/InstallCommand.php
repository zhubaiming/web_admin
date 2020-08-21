<?php

namespace Toolman\Admin\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * 命令名称，在控制台执行命令时用到
     *
     * @var string
     */
    protected $signature = 'admin:install';

    /**
     * 命令描述
     *
     * @var string
     */
    protected $description = '安装后台包';

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
     * 命令具体执行逻辑放在这里
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm('是否确定安装该 web_admin 后台包？')) {
            $install_pwd = $this->secret('请输入安装密码进行安装');
            if ($install_pwd != '123456') {
                $this->error('安装密码错误，退出安装');
                exit(-1);
            } else {
                $this->info('安装即将开始');
                $this->output->progressStart(5);   // 创建进度条，n - 进度条步骤总数
                /*
                1、创建相关模型
                2、执行数据迁移（数据迁移中执行数据填充)
                3、执行控制器文件填充
                 */
                $this->initAdminModels();
                $this->initDatabase();
                $this->initAdminDirectory();

                $this->output->progressAdvance();
                $this->info('web_admin 后台包全部安装已完成，欢迎使用！');
                $this->output->progressFinish();
            }
        } else {
            exit(0);
        }
    }

    public function initAdminModels()
    {
        $this->directory = config('admin.directory.model');

        if (is_dir($this->directory)) {
            $this->error('文件夹已存在');
            $this->call('admin:uninstall');
            exit(-1);
        } else {
            $this->makeDir();
            $this->makeAdminUserModel();
            $this->makeAdminMenuModel();
            $this->output->progressAdvance();
            $this->info('模型创建已完成！');
        }
    }

    public function makeAdminUserModel()
    {
        $authController = $this->directory . '/User.php';

        $contents = $this->getStub('Models/User');

        $this->laravel['files']->put(
            $authController,
            str_replace('', '', $contents)
        );
    }

    public function makeAdminMenuModel()
    {
        $authController = $this->directory . '/Menu.php';

        $contents = $this->getStub('Models/Menu');

        $this->laravel['files']->put(
            $authController,
            str_replace('', '', $contents)
        );
    }

    public function initDatabase()
    {
        $this->call('migrate:fresh');

        $this->output->progressAdvance();
        $this->info('数据迁移已完成！');

        $userModel = config('admin.database.user_model');

        if ($userModel::count() == 0) {
            $this->call('db:seed', ['--class' => \App\Models\admin\User::class]);
            $this->output->progressAdvance();
            $this->info('数据填充已完成！');
        }
    }

    protected function initAdminDirectory()
    {
        $this->directory = config('admin.directory.controller');

        if (is_dir($this->directory)) {
            $this->error('文件夹已存在');
            $this->call('admin:uninstall');
            exit(-1);
        } else {
            $this->makeDir();
            $this->makeAuthController();
            $this->makeHomeController();
            $this->output->progressAdvance();
            $this->info('控制器创建已完成！');
        }
    }

    public function makeAuthController()
    {
        $this->makeDir('Auth');

        $authController = $this->directory . '/Auth/AuthController.php';

        $contents = $this->getStub('Controllers/AuthController');

        $this->laravel['files']->put(
            $authController,
            str_replace('DummyNamespace', config('admin.route.namespace') . '\\Auth', $contents)
        );
    }

    public function makeHomeController()
    {
        $this->makeDir('Home');

        $authController = $this->directory . '/Home/HomeController.php';

        $contents = $this->getStub('Controllers/HomeController');

        $this->laravel['files']->put(
            $authController,
            str_replace('DummyNamespace', config('admin.route.namespace') . '\\Home', $contents)
        );
    }

    protected function getStub($name)
    {
        return $this->laravel['files']->get(__DIR__ . "/stubs/$name.stub");
    }

    protected function makeDir($path = '')
    {
        $this->laravel['files']->makeDirectory("{$this->directory}/$path", 0755, true, true);
    }
}
