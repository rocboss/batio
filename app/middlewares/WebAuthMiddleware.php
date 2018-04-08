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

        app()->halt([
            'code' => 401,
            'msg'  => '[401 Unauthorized].'.app()->get('auth.error')
        ], 401);

        exit;
    }
}