<p align="center">Web_Admin</p>
<p align="center">中文文档</p>

## 要求
 - PHP >= 7.0.0
 - Laravel >= 6.0
 - PHP 扩展：
 
## 安装方法

> 该软件包需要PHP 7+和Laravel 6.*，对于旧版本，请参考1.4

首先，安装laravel 5.5，并确保数据库连接设置正确。

```
composer require toolman/laravel-admin
```

然后运行以下命令来发布资产并进行配置：

```
php artisan vendor:publish --provider="Toolman\Admin\AdminServiceProvider"
```

运行命令后，您可以在config / admin.php中找到配置文件，在此文件中，您可以更改安装目录，数据库连接或表名。

在最后运行以下命令以完成安装。

```
php artisan admin:install
```

## 构型

config / admin.php文件包含一系列配置，您可以在其中找到默认配置。

## 扩展

<p>未完待续。。。</p>
