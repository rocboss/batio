# Batio
[![Build Status](https://www.travis-ci.org/rocboss/batio.svg?branch=master)](https://www.travis-ci.org/rocboss/batio)
![Branch master](https://img.shields.io/badge/branch-master-brightgreen.svg?style=flat-square)
[![Latest Stable Version](https://poser.pugx.org/rocboss/batio/v/stable.svg?format=flat-square)](https://packagist.org/packages/rocboss/batio)
[![Latest Unstable Version](https://poser.pugx.org/rocboss/batio/v/unstable.svg?format=flat-square)](https://packagist.org/packages/rocboss/batio)
[![License](https://poser.pugx.org/rocboss/batio/license?format=flat-square)](https://packagist.org/packages/rocboss/batio)

>   A fast and extensible micro-framework for PHP to build RESTful API.

>   一个快速的、可扩展的专注构建RESTful API的PHP框架

## 安装

```bash
// 方式一.  使用 git clone
git clone https://github.com/rocboss/batio.git batio

// 方式二. 使用 composer
composer create-project --prefer-dist rocboss/batio batio

cd batio
cp .env.example .env
// 编辑配置
vim .env
composer install
cd app
chmod -R 755 storage
php -S 127.0.0.1:8888 -t public
```
在浏览器中输入 `http://127.0.0.1:8888` 网址，您就可以看到本项目页面。

你也可以设置 Web Server 的网站根目录指向到 `public` 文件夹，并使用 `composer` 来安装或更新依赖包等操作。

初次安装需要编辑项目根目录下的 `.env` 文件中相关配置信息，你也可以根据具体需求在该文件中扩展其他系统配置。


### 框架使用
在 `app\config\routes.php` 中你可以自定义API路由。

这是一个无鉴权的路由，访问首页时，直接映射到 `api\HomeController` 控制器，执行下面的 `index` 方法，注意控制器方法类型需要为 `protected`。

```php
route('GET /', ['api\HomeController', 'index']);
```

`Batio` 封装了基于JWT的一种简单的鉴权模型，对应的需要鉴权API的路由如下，只需调用 `auth()` 方法，传入自定义认证中间件`AuthMiddleware`。
```php
route('GET /', ['api\HomeController', 'index'])->auth('web');
```

请求时在 `header` 中传递以 `X-Authorization` 为key的 `JWT` 值给服务器即可。
```
// 该方法可用来获取 JWT
\Auth::getToken($uid);
```

缓存（Cache）的使用

```php
if (app()->cache('data')->contains('foo')) {
    $unit = app()->cache('data')->fetch('foo');
} else {
    $bar = 'bar cache';
    app()->cache('data')->save('foo', $bar);
}
```
日志（Log）的使用

```php
$logger = app()->log()->debug('debug log');
```


数据库（Database）与模型（Models）

在 `app\models` 中存放的是 `model` 和 `service` ，`model` 主要和数据库（Database）直接打交道，官方推荐的做法由 `service` 去调用 `model` ，`controller` 调用 `service`，这样设计会使得分层更加合理，便于系统业务的扩展和日后维护。

### 主要依赖
```
lcobucci/jwt: 3.2.*
mikecao/flight: 1.3.*
catfan/medoo: 1.4.*
katzgrau/klogger: 1.*
doctrine/cache: 1.4.*
vlucas/phpdotenv: 2.0.*
```
`Batio` 使用一些优秀的第三方组件，你可以从他们各自网站获得相应具体文档。


## 授权协议

 [MIT 授权协议](http://opensource.org/licenses/MIT)
