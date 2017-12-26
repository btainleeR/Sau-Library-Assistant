<?php 

//  Author: Btailee
//  Time:   2017/12/27
//  Func:   添加选课信息到队列

$filePath = "./info.txt";

if(file_exists($filePath))
{
    $content = file_get_contents($filePath);
    $arr = unserialize($content);
    $tmpArr = array(
        'id'    =>$_GET['id'],
        'pwd'   =>$_GET['pwd'],
        'date'  =>
    );
}