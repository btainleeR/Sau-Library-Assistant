<?php
return array(
	//'配置项'=>'配置值'
    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'seat',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '',          // 密码
    'DB_PORT'               =>  '3306',        // 端口

    'DEFAULT_MODULE' => 'Seat',             //默认模块

    'TRY_TIMES' =>'3',                      //选课失败最多尝试次数
    'SLEEP_TIME'=>'3',                      //选座失败后重新尝试时间间隔
    'TMPL_CACHE_ON' => false,
);