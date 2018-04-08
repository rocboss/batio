<?php
/**
 * BaseController
 */
class BaseController
{
    protected static $_name;
    protected static $_class;
    protected static $_method;

    public function __construct()
    {
        app()->auth(app()->router()->current()->callback);
    }

    public static function __callStatic($method, $arguments)
    {
        self::$_name = $method;
        self::$_class = get_called_class();
        self::$_method = $method;

        call_user_func_array([(new self::$_class()), self::$_method], $arguments);
    }
}
