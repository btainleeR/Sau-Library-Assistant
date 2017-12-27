<?php
/**
 * Created by PhpStorm.
 * User: Btainlee
 * Date: 2017/12/27
 * Time: 20:53
 */

require '../vendor/autoload.php';
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'http://www.qilingwang.net',
    'timeout' => 10,
]);

$res = $client->request('GET','/admin/login/login.php');

echo $res->getBody();

$res2 = $client->get('http://www.baidu.com');

echo $res2->getBody();

$request = new \GuzzleHttp\Psr7\Request('GET','http://www.baidu.com');

$res3 = $client->send($request,['timeout' => 2]);

echo $res3->getBody();