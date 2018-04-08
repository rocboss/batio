<?php

/**
 * The authentication middleware for web module.
 */
class WebAuthMiddleware implements AuthMiddleware
{
    /**
     * check
     *
     * @return mixed
     */
    public static function check()
    {
        $headers = getAllHeader();

        if (!empty($headers['x-authorization'])) {
            $verify = Auth::verify($headers['x-authorization']);
            if ($verify === 1) {
                return true;
            }
        }

        Flight::halt([
            'code' => 401,
            'msg'  => '[401 Unauthorized].'.Flight::get('auth.error')
        ], 401);

        exit;
    }
}