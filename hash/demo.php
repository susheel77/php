<?php
error_reporting(E_ALL);
set_time_limit(36000);

if(file_exists(dirname(dirname(__FILE__)) . "/autoload/loader.class.php")){
    require_once(dirname(dirname(__FILE__)) . "/autoload/loader.class.php");
}else{
    throw new Exception('autoload class is not exists');
}

spl_autoload_register(array('Loader','loadClass'));

$redis_config = array(
    'server_1' => array('host' => '127.0.0.1', 'port' => 6379),
    'server_2' => array('host' => '127.0.0.1', 'port' => 6380),
);

$key                = 'username_category';
$consistent_hash    = Consistent_Hash::getInstance($redis_config);
$redis_key          = $consistent_hash->getRedisServerConfig($key);
$config             = $redis_config[$redis_key];

$redis = RedisClient::getInstance($config);

$redis->set($key, 'shopping'); 
