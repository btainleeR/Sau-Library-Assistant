<?php
/**
 * Created by PhpStorm.
 * User: Btainlee
 * Date: 2017/12/28
 * Time: 16:16
 */
namespace app\controllers;

use yii\web\Controller;

class IndexController extends Controller
{
    public function actionIndex($message = 'hello')
    {
        echo 'here is echo content';
        return $this->render('index',['message' => $message]);
    }
}