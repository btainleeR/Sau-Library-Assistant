<?php
//  Author: Btainlee
//  Time:   2017/12/26
//  Func:   get owner info

//获得cookie
$url = 'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/login.aspx';
$postData = array(
    'id'    =>  '153401040222',
    'pwd'   =>  '153401040222',
    'act'   =>  'login',
);
$curl = curl_init();    
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_HEADER,0);    //hide header infomation
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);    // put return infomation into file
curl_setopt($curl,CURLOPT_COOKIEJAR,'./sauCookie.txt');   // file location
curl_setopt($curl,CURLOPT_POST,1);              //post method 
curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($postData));  //post data infomation
curl_exec($curl);   //run
curl_close($curl);  //close



$baseUrl = 'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/data/searchAccount.aspx?';

$getData = array(
    'type'  => '',
    'term'  =>$_GET['owner'],
    '_'     => time().rand(111,999),
);

$ch = curl_init();
foreach($getData as $k=>$v)
{
    if($v != ''){
        $v = curl_escape($ch,$v);
    }
    $baseUrl .= $k.'='.$v.'&';
}
$url = substr($baseUrl,0,-1);

curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_COOKIEFILE,'./sauCookie.txt');
$output = curl_exec($ch);
$output = json_decode($output);
curl_close($ch);


echo "<table><tr><td>name</td><td>学号</td><td>手机号码</td><td>邮箱</td></tr>";
foreach($output as $k => $v)
{
    $str = "<tr><td>".$v->label."</td><td>".$v->szLogonName."</td><td>".$v->szHandPhone."</td><td>".$v->szEmail."</td></tr>";
    echo $str;
}
echo "</table>";