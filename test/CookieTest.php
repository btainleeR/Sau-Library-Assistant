<?php
/**
 * Created by PhpStorm.
 * User: Btainlee
 * Date: 2017/12/30
 * Time: 14:36
 */
require('../vendor/autoload.php');

namespace test;
use GuzzleHttp\Client;

class CookieTest
{
    public function test()
    {
        //登录
        $client = new Client(['cookies'=>true]);

    }
}