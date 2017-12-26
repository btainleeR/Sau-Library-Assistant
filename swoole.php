<?php

//  Author: Btainlee
//  Time:   2017/12/26
//  Func:   auto get seat

// 判断00:00
function isMidnight() {
    $time = date('Hi');
    if($time == "0000")
    {
        return true;
    }
}

//抢座
function getseat()
{
    $url = './demo.php';
    //设置访问地址
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

    // 抢课定时器
    $timerNu = swoole_timer_tick(2000,function($timer_id){
        global $ch;
        $result = curl_exec($ch);
        $result = json_decode($result);
        if($result->ret != 0)   //预约成功
        {
            swoole_timer_clear($timer_id);
            curl_close($ch);
        }
    });

    // 抢课时长定时器,市场设置为4分钟
    swoole_timer_after(240000,function(){
        global $timerNu;
        swoole_timer_clear($timerNu);
    });
}

// 动作触发器
swoole_timer_tick(2000,function($timer_id){
    if(isMidnight())
    {
        //激活抢课定时器
        getseat();
        // swoole_timer_tick($timer_id);
    }
});


