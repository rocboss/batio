# Batio
[![Build Status](https://www.travis-ci.org/rocboss/batio.svg?branch=master)](https://www.travis-ci.org/rocboss/batio)
![Branch master](https://img.shields.io/badge/branch-master-brightgreen.svg?style=flat-square)
[![Latest Stable Version](https://poser.pugx.org/rocboss/batio/v/stable.svg?format=flat-square)](https://packagist.org/packages/rocboss/batio)
[![Latest Unstable Version](https://poser.pugx.org/rocboss/batio/v/unstable.svg?format=flat-square)](https://packagist.org/packages/rocboss/batio)
[![License](https://poser.pugx.org/rocboss/batio/license?format=flat-square)](https://packagist.org/packages/rocboss/batio)

English | [简体中文](./README_zh-CN.md)

>   A fast and extensible micro-framework for PHP to build RESTful API.

## 1. Install

```bash
// (Recommend) If you’re using Composer, you can run the following command:
composer create-project --prefer-dist rocboss/batio batio
```

```bash
// Or git clone
git clone https://github.com/rocboss/batio.git batio
```

```bash
cd batio

cp .env.example .env
// Edit .env file
vim .env

composer install
chmod -R 755 app/storage

php -S 127.0.0.1:8888 -t public
```
Enter `http://127.0.0.1:8888` in the browser's address bar. If everything is correct, you can get the following return:

```json
{
  "code": 0,
  "msg": "success",
  "data": "version: Batio 1.0.0"
}
```

> Note: the initial installation needs to edit the related configuration information in the `.env` file under the project root, and you can also extend the other configuration in the file according to specific requirements.


## 2. Framework

### 2.1 Router
In `app\config\routes.php`, you can customize API routes.

```php
route('GET /', ['api\HomeController', 'index']);
```

> This is an ordinary route. When you visit the home page, you directly map to the `api\HomeController` controller, execute the following `index` method, and note that the type of controller method needs to be `protected`.


### 2.2 Middlewares

In `app\config\app.php`, you can customize `Middleware` for routes, such as authorization authentication, user roles control, etc.

```php
// Middlewares
'middlewares' => [
    'auth' => AuthMiddleware::class,
],
```

`Batio` encapsulates a simple authentication model based on JWT, just call the `auth()` method after the routing of the authentication API.

```php
route('GET /', ['api\HomeController', 'user'])->auth();
```

The example

```json
// Fail
{
    "code": 401,
    "msg": "[401 Unauthorized]."
}

// Success
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

> When you send a request, pass the `X-Authorization` of `JWT` value to the server in `header`.

```php
// This method can be used to obtain JWT.
\Auth::getToken($uid);
```

### 2.3 Cache

```php
if (app()->cache('data')->contains('foo')) {
    $unit = app()->cache('data')->fetch('foo');
} else {
    $bar = 'bar cache';
    app()->cache('data')->save('foo', $bar);
}
```

### 2.4 Log

```php
$logger = app()->log()->debug('debug log');
```


### 2.5 Database & Models

```php
$userModel = new UserModel();
$userModel->name = 'Jack';
$userModel->email = 'bar@foo.com';
$userModel->avatar = 'https://foo.com/xxxxxx.png';
$userModel->password = password_hash("mypassword", PASSWORD_DEFAULT);
$userModel->save();
```

> In `app\models`, `model` and `service` are stored, `model` is mainly dealing with database. The official recommended practice is that `service` calls `model`, `controller` calls `service`, so that the design makes the layering more reasonable, and the functional modules are decoupled to facilitate the business system. 

### Mainly depended on
```
lcobucci/jwt: 3.2.*
mikecao/flight: 1.3.*
aryelgois/medools: 5.0
catfan/medoo: 1.5.*
monolog/monolog: 1.23.*
doctrine/cache: 1.4.*
vlucas/phpdotenv: 2.0.*
```

`Batio` uses some excellent third party components, and you can get specific documents from their websites.


## Authorization agreement

 [MIT Agreement](http://opensource.org/licenses/MIT)
