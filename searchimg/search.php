<meta charset='utf8' />
<?php
if(file_exists('../autoload/loader.class.php')){
    require_once('../autoload/loader.class.php');
}else{
    throw new Exception('loader.class.php is not exists');
}

spl_autoload_register(array('loader', 'loadClass'));

$Upload = Upload::getInstance();
$ImagesHash = ImagesHash::getInstance();

$conf = array(
    'host' => 'localhost',
    'user' => 'root',
    'pass' => 'root',
    'db'   => 'demo',
    'port' => '3306'
);
$_name = 'images';
$DBHelper = DBHelper::getInstance($conf);

$act = isset($_GET['act']) ? $_GET['act'] : false;
if($act == 'file'){
    $image_info = $Upload->uploadFile('imgkeyword');

    if($image_info['code'] !== 0){
        throw new Exception('上传图片错误');
    }
    $data = array(
        'path' => $image_info['path'],
        'hash' => $ImagesHash->getImagesHash($image_info['path'])
    );
    $DBHelper->write($_name, $data);

}else{
?>
<form action='?act=file' method='post' enctype="multipart/form-data">
    上传图片: <input name='imgkeyword' type='file' />
    <br /><br />
    <input name='submit' value='上传' type='submit' />
</form>
<?php
}
?>