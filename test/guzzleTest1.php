<?php
/**
 * Created by PhpStorm.
 * User: Btainlee
 * Date: 2017/12/27
 * Time: 20:21
 */

require_once('../vendor/autoload.php');

$client = new GuzzleHttp\Client();

$res = $client->request('GET','https://github.com/user');

echo $res->getStatusCode();

print_r($res->getHeader('Content-type'));

echo $res->getBody();

//来一个异步请求

$request = new \GuzzleHttp\Psr7\Request('GET','http://httpbin.org');

$promise = $client->sendAsync($request)->then(function ($response) {
    echo 'I complete! '.$response->getBody();
});
$promise->wait();
