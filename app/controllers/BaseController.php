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
        // Need Authorization
        if (in_array(self::$_class.'@'.self::$_name, Auth::$authActions)) {
            $headers = getAllHeader();

            if (!empty($headers['x-authorization'])) {
                $verify = Auth::verify($headers['x-authorization']);
                if ($verify === 1) {
                    return $this;
                }
            }

            Flight::halt([
                'code' => 401,
                'msg'  => '[401 Unauthorized].'.Flight::get('auth.error')
            ], 401);

            exit();
        }
    }

    public static function __callStatic($name, $arguments)
    {
        self::$_name = $name;
        self::$_class = get_called_class();
        self::$_method = 'action'.ucfirst($name);

        call_user_func_array([(new self::$_class()), self::$_method], $arguments);
    }
}
