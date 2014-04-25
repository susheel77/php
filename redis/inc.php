<?php
if(file_exists("./redis.class.php")) include_once("./redis.class.php");

// 配置选项, 主机， 端口, redis的数据库
$conf = array(
    'host'     => '127.0.0.1',
    'port'     => 6379,
    'database' => 0

);

$redis = Redis::getInstance($conf);
$flag = "register";
$name = $redis->set('name', 'zhanglei', 3600);
?>