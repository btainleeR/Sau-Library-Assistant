<?php
namespace Test;
require './vendor/autoload.php';


use GuzzleHttp\Client;

$client = new Client(['cookies'=>true]);
$res = $client->request('POST','http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/login.aspx',['form_params'=>['id'=>'143405010219','pwd'=>'220910','act'=>'login']]);

echo $res->getBody();

echo "<br><br><hr>";

$result = $client->request('GET','http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/reserve.aspx?dev_id=100457447&type=dev&start=2018-01-10+07%3A30&end=2018-01-10+12%3A30&start_time=0730&end_time=1230&act=set_resv&_=1515502143778');
echo  $result->getBody();

