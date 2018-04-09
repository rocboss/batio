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

    /**
     * This is a demo method for model.
     *
     * @return void
     */
    protected function test()
    {
        $userModel = new UserModel();
        $userModel->dump([
            'id[>]' => 1,
            'LIMIT' => [0, 10],
        ]);
    }

    /**
     * This is a demo method for authentication.
     *
     * @return void
     */
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
