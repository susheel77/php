<?php
// 定义常量
define('APP_PATH', dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);
define('CONFIG', APP_PATH . DS . 'config');

// 加载autoload类
if (!file_exists('../autoload/loader.class.php')) 
{
    throw new Exception('autoload类文件不存在');
}
include_once('../autoload/loader.class.php');
spl_autoload_register(array('Loader', 'loadClass'));

$render		= new Render();
$pagelet	= new pageletSkeleton();
$render->renderPage($pagelet);

