<?php

use Medoo\Medoo;
use Lcobucci\JWT\Builder;
use Katzgrau\KLogger\Logger;
use Psr\Log\LogLevel;

/**
 * Batio kernel class
 * Author Roc. [https://github.com/rocboss/batio]
 */
class Batio
{
    const VERSION = 'Batio 0.1.1';

    protected static $_log;
    protected static $_db = [];
    protected static $_cache = [];

    /**
     * Bootstrap
     * @method bootstrap
     * @return void
     */
    public static function bootstrap()
    {
        // Set timezone
        date_default_timezone_set(env('APP_TIMEZONE', 'Asia/Shanghai'));

        // Filters
        if (get_magic_quotes_gpc()) {
            $_GET = self::_stripslashesDeep($_GET);
            $_POST = self::_stripslashesDeep($_POST);
            $_COOKIE = self::_stripslashesDeep($_COOKIE);
        }

        $_REQUEST = array_merge($_GET, $_POST, $_COOKIE);

        /*
        |--------------------------------------------------------------------------
        | Flight registers/maps start
        |--------------------------------------------------------------------------
        | You can register more components in here.
        */

        // Log
        app()->register('log', [__CLASS__, 'log']);

        // DB
        app()->register('db', [__CLASS__, 'db']);

        // Cache
        app()->register('cache', [__CLASS__, 'cache']);

        // Auth
        app()->map('auth', function ($callback) {
            if (!empty($callback) && is_array($callback)) {
                $callbackHash = md5(implode('@', $callback));
                if (array_key_exists($callbackHash, Auth::$authActions)) {
                    if (app()->get('auth.collections')[Auth::$authActions[$callbackHash]]) {
                        $middleware = app()->get('auth.collections')[Auth::$authActions[$callbackHash]];
                        return $middleware::check();
                        
                    }
                    throw new Exception('Can\'t find the auth middleware.');    
                }
            }
        });

        // Halt response
        app()->map('halt', [__CLASS__, 'halt']);

        // Handle 404 error
        app()->map('notFound', function () {
            // Record Log.
            app()->log()->error('404 NOT FOUND.', json_decode(json_encode(app()->request()), true));

            return self::halt([
                'code' => 404,
                'msg'  => '404 NOT FOUND.'
            ], 404);
        });

        // Handle 500 error
        app()->map('error', function (Exception $ex) {
            // Record Log.
            app()->log()->error("500 Internal Server Error.\n".$ex->getMessage()."\n".$ex->getTraceAsString());

            $traceArr = explode("\n", $ex->getTraceAsString());
            array_unshift($traceArr, $ex->getMessage());

            return self::halt([
                'code' => 500,
                'msg'  => '500 Internal Server Error.',
                'data' => filter_var(env('DEBUG_MODE', false), FILTER_VALIDATE_BOOLEAN) ? $traceArr : 'Please check the error log.'
            ], 500);
        });

        /*
        |--------------------------------------------------------------------------
        | Flight registers/maps end
        |--------------------------------------------------------------------------
        */
        // Route
        require APP_PATH.'/config/routes.php';
    }

    /**
     * Log
     * @method log
     * @param  string $prefix
     * @return Object
     */
    public static function log($prefix = 'batio_')
    {
        $logDir = app()->get('log.path');

        if (!isset(self::$_log)) {
            $options = [
                'extension'  => 'log',
                'dateFormat' => 'Y-m-d H:i:s',
                'prefix'     => $prefix,
            ];
            $logger = new Logger($logDir, LogLevel::DEBUG, $options);
            self::$_log = $logger;
        }

        return self::$_log;
    }

    /**
     * Get database instance
     * @method db
     * @param  string $name
     * @return Object
     */
    public static function db($name = 'default')
    {
        if (!isset(self::$_db[$name])) {

            $db = app()->get('db.'.$name);

            $dbInstance = new Medoo([
                'database_type' => 'mysql',
                'database_name' => isset($db['name']) ? $db['name'] : 'batio',
                'server'        => isset($db['host']) ? $db['host'] : 'localhost',
                'port'          => isset($db['port']) ? $db['port'] : 3306,
                'username'      => isset($db['user']) ? $db['user'] : 'root',
                'password'      => isset($db['pass']) ? $db['pass'] : '',
                'charset'       => isset($db['charset']) ? $db['charset'] : 'utf8'
            ]);

            self::$_db[$name] = $dbInstance;
        }

        return self::$_db[$name];
    }

    /**
     * Cache
     * @method cache
     * @param  string $path
     * @return mixed
     */
    public static function cache($path = 'data')
    {
        $path = app()->get('cache.path').'/'.$path;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        if (!isset(self::$_cache[$path])) {
            $cache = new \Doctrine\Common\Cache\FilesystemCache($path, '.cache');
            self::$_cache[$path] = $cache;
        }

        return self::$_cache[$path];
    }

    /**
     * Halt
     * Do something before sending response.
     * @method halt
     * @param  array   $msg
     * @param  integer $code
     * @return mixed
     */
    public static function halt(array $msg, $code = 200)
    {
        return app()->response(false)
                ->status($code)
                ->header("Content-Type", "application/json; charset=utf8")
                ->write(json_encode($msg))
                ->send();
    }

    /**
     * _stripslashesDeep
     * Deep data filters.
     * @method _stripslashesDeep
     * @param  mixed   $data
     * @return mixed
     */
    protected static function _stripslashesDeep($data)
    {
        if (is_array($data)) {
            return array_map([__CLASS__, __FUNCTION__], $data);
        } else {
            return stripslashes($data);
        }
    }
}
