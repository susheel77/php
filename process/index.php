<?php
$load_files = dirname(dirname(__FILE__)) . '/autoload/loader.class.php';
if (file_exists($load_files))
{
    include_once($load_files);
}
else
{
    throw new Exception('自动加载文件不存在');
}

spl_autoload_register(array('Loader', 'loadClass'));


$conf = array(
    'class'     => 'RedisClient',
    'method'    => 'set',
    'params'    => array('key' => 'name', 'value' => 'zhanglei'),
    'counts'    => 3
);

try {
    $daemon = Multidaemon::getInstance($conf);
} catch (Exception $e) {
    echo $e->getCode() . "\t" . $e->getMessage();
}

