<?php
namespace api;

use BaseController;
use model\UserModel;

/**
 * HomeController
 */
class HomeController extends BaseController
{
    /**
     * This is a demo method.
     * @method index
     * @return mixed
     */
    protected function index()
    {
        return app()->json([
            'code' => 0,
            'msg'  => 'success',
            'data' => 'version: '.\Batio::VERSION,
        ]);
    }

    protected function user()
    {
        return app()->json([
            'code' => 0,
            'msg'  => 'success',
            'data' => [
                'uid' => 1,
                'user_name' => 'Jack',
                'user_age' => 18,
            ]
        ]);
    }
}
