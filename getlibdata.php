<?php
//  Author: Btainlee
//  Time:   2017/12/23
//  Func:   优雅找图书馆座位

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

// 抓取教室座位和座位号的关系

$ch = curl_init();
$room_id = array(
    '701'   =>      '107396184',
    '702'   =>      '100457241',
    '634'   =>      '100456540',
    '637'   =>      '100456542',
    '643'   =>      '100456544',
    '648'   =>      '100456546',
    '652'   =>      '100456548',
    '655'   =>      '100456550',
    '620'   =>      '100456448',
    '623'   =>      '100456530',
    '626'   =>      '100456532',
    '629'   =>      '100456534',
    '630'   =>      '100456536',
    '631'   =>      '100456538',
);

$baseUrl = 'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/device.aspx?';

$getData = array(
    'byType'=>'devcls',
    'classkind'=>'8',
    'display'=>'fp',
    'md'=>'d',
    'room_id'=>'100456538',
    'purpose'=>'',
    'cld_name'=>'default',
    'date'=> date("Y-m-d",time()),
    'fr_start'=>'15:40',
    'fr_end'=>'16:40',
    'act'=>'get_rsv_sta',
    '_'=>'1514014834075',
);
$getData['room_id'] = $room_id[$_GET['room']];
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

$seatArray = array();
foreach($output->data as $v)
{
   $seatArray[$v->devId] = $v->name;
}


echo "<h1>请在url中room参数后改自习室查询座位号</h1>";
echo "<h3>可选教室:</h3>";
echo "<h1><font color='red'>";
foreach($room_id as $k=>$v)
{
    echo "$k"."、";
}
echo "</font><h1>";
echo "<table style='border: 1px solid red'><tr><td>编号</td><td>座位</td></tr>";
foreach($seatArray as $k => $v)
{
    echo "<tr><td>".$k."</td><td>".$v."</td></tr>";
}
echo "</table>";



