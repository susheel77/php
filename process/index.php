<?php
if (file_exists('../autoload/loader.class.php'))
{
    include_once('../autoload/loader.class.php');
}
else
{
    throw new Exception('自动加载文件不存在', 100002);
}

spl_autoload_register(array('Loader', 'loadClass'));


$conf = array(
    'class'     => 'RedisClient',
    'method'    => 'exists',
    'params'    => '111',
    'counts'    => 3
);

try {
    $daemon = Multidaemon::getInstance($conf);
} catch (Exception $e) {
    echo $e->getCode() . "\t" . $e->getMessage();
}

