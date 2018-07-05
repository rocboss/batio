# Batio
[![Build Status](https://www.travis-ci.org/rocboss/batio.svg?branch=master)](https://www.travis-ci.org/rocboss/batio)
![Branch master](https://img.shields.io/badge/branch-master-brightgreen.svg?style=flat-square)
[![Latest Stable Version](https://poser.pugx.org/rocboss/batio/v/stable.svg?format=flat-square)](https://packagist.org/packages/rocboss/batio)
[![Latest Unstable Version](https://poser.pugx.org/rocboss/batio/v/unstable.svg?format=flat-square)](https://packagist.org/packages/rocboss/batio)
[![License](https://poser.pugx.org/rocboss/batio/license?format=flat-square)](https://packagist.org/packages/rocboss/batio)

>   一个快速的、可扩展的专注构建RESTful API的PHP框架

## 1. 安装

```bash
// 方式一.  使用 git clone
git clone https://github.com/rocboss/batio.git batio
```

```bash
// 方式二. 使用 composer 安装 （推荐）
composer create-project --prefer-dist rocboss/batio batio
```

```bash
cd batio

cp .env.example .env
// 编辑系统配置
vim .env

composer install
chmod -R 755 app/storage

php -S 127.0.0.1:8888 -t public
```
在浏览器地址栏输入 `http://127.0.0.1:8888` 网址，一切正常的情况下您可以获取如下返回：

```json
{
  "code": 0,
  "msg": "success",
  "data": "version: Batio 1.0.0"
}
```

> 注意：初次安装需要编辑项目根目录下的 `.env` 文件中相关配置信息，你也可以根据具体需求在该文件中扩展其他业务配置。


## 2. 框架使用

### 2.1 路由(Router)
在 `app\config\routes.php` 中你可以自定义 API 路由。

```php
route('GET /', ['api\HomeController', 'index']);
```

> 这是一个无鉴权的路由，访问首页时，直接映射到 `api\HomeController` 控制器，执行下面的 `index` 方法，注意控制器方法类型需要为 `protected`。

### 2.2 中间件(Middlewares)

在 `app\config\app.php` 中你可以自定义 `Middleware`路由中间件，如实现授权验证，用户权限控制等。

```php
// Middlewares
'middlewares' => [
    'auth' => AuthMiddleware::class,
],
```

`Batio` 封装了基于JWT的一种简单的鉴权模型，只需在需要鉴权API的路由后调用 `auth()` 方法，即可调用自定义认证中间件`AuthMiddleware`。

```php
route('GET /', ['api\HomeController', 'user'])->auth();
```

返回示例

```json
// 失败，被拦截
{
    "code": 401,
    "msg": "[401 Unauthorized]."
}

// 成功，正常返回
{
    "code": 0,
    "msg": "success",
    "data": {
        "uid": 1,
        "user_name": "Jack",
        "user_age": 18
    }
}
```

请求时在 `header` 中传递以 `X-Authorization` 为key的 `JWT` 值给服务器即可。
```
// 该方法可用来获取 JWT
\Auth::getToken($uid);
```

### 2.3 缓存(Cache)

```php
if (app()->cache('data')->contains('foo')) {
    $unit = app()->cache('data')->fetch('foo');
} else {
    $bar = 'bar cache';
    app()->cache('data')->save('foo', $bar);
}
```

### 2.4 日志(Log)

```php
$logger = app()->log()->debug('debug log');
```


### 2.5 数据库(Database)与模型(Models)

```php
$userModel = new UserModel();
$userModel->name = 'Jack';
$userModel->email = 'bar@foo.com';
$userModel->avatar = 'https://foo.com/xxxxxx.png';
$userModel->password = password_hash("mypassword", PASSWORD_DEFAULT);
$userModel->save();
```

> 在 `app\models` 中存放的是 `model` 和 `service` ，`model` 主要和数据库（Database）直接打交道，官方推荐的做法由 `service` 去调用 `model` ，`controller` 调用 `service`，这样设计会使得分层更加合理，各功能模块进一步解耦，便于业务系统的扩展和日后维护。

### 主要依赖
```
lcobucci/jwt: 3.2.*
mikecao/flight: 1.3.*
aryelgois/medools: 5.0
catfan/medoo: 1.5.*
monolog/monolog: 1.23.*
doctrine/cache: 1.4.*
vlucas/phpdotenv: 2.0.*
```

`Batio` 使用一些优秀的第三方组件，你可以从他们各自网站获得相应具体文档。


## 授权协议

 [MIT 授权协议](http://opensource.org/licenses/MIT)
