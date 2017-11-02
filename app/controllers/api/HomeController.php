<?php
namespace api;

use Flight;
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
    public function actionIndex()
    {
        return Flight::json([
            'code' => 0,
            'msg'  => 'success',
            'data' => 'version: '.\Batio::VERSION
        ]);
    }
}
