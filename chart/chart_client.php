<?php
/**
 * @author zhanglei <zhanglei@19881228@sina.com>
 * @brief chart客户端
 * @date 2014-04-28 14:12:00
 */
$host = '127.0.0.1';
$port = 1111;
set_time_limit(1000);

if(!($socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP))){
    throw new Exception('can not create socket');
}

if(!socket_connect($socket, $host, $port)){
    throw new Exception('can not connect server socket');
}

if(empty($_POST['message'])) $_POST['message'] = 'a';
$message = htmlspecialchars(addslashes($_POST['message']));

if(!socket_sendto($socket, $message, strlen($message), 0, $host, $port)){
    throw new Exception('can not send to the socket server');
}

while($buffer = socket_read($socket, 1024)){
    echo $buffer;
}
?>