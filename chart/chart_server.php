<?php
/**
 * @author zhanglei <zhanglei19881228@sina.com>
 * @brife 聊天server端
 * @date 2014-04-28 14:00:00
 */
$host = '127.0.0.1';
$port = 1111;
set_time_limit(0);

$redis_key = 'chart';

if(file_exists('../redis/redis.class.php')){
    include_once('../redis/redis.class.php');
}else{
    throw new Exception('class redis is not exists');
}

$redis_port = 6379;
$conf = array(
    'host' => $host,
    'port' => $redis_port
);
$redis = Redis::getInstance($conf);

if(!($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP))){
    throw new Exception('socket can not create');
}

if(!socket_bind($socket, $host, $port)){
    throw new Exception('socket can not bind on ' . $host);
}

if(!socket_listen($socket, 3)){
    throw new Exception('socket can not listen on port' . $port);
}

while($accept_socket = socket_accept($socket)){
    $message = socket_read($accept_socket, 1024);
    socket_getpeername($accept_socket, $client_ip, $client_port);
    socket_write($accept_socket, $message, strlen($message));
    $redis->lpush($redis_key, $message);
}
?>