<?php
/**
 * @author  zhanglei <zhanglei19881228@sina.com>
 * @brief   通过图片搜索相类似的图片
 * @date    2014-07-14 17:14
 */
class SearchImages extends ImageHash{
    
    private $DBHelper = null;
    private $DBConf = array(
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'root',
        'name' => 'demo'
    );
    private static $_instance = null;
    private static $ImgExtArray = array(
        'jpg', 'png', 'gif'
    );
    private $_name = 'images';
    
    // 单例
    public function getInstance(){
        if(self::$_instance === null){
            self::$_instance = new SearchImages();
        }
        return self::$_instance;
    }
    
    // autoload
    public function __autoload($class){
        $loadpath = array(
            'mysql'
        );
        $classname = sprintf("%s.class.php", $class);
        foreach($loadpath as $path){
            $filename = sprintf("../%s/%s", $path, $classname);
            if(file_exists($filename) && is_file($filename)){
                require_once($filename);
            }else{
                throw new Exception($classname . '文件不存在');
            }
        }
    }
    
    // 私有化实例化
    private function __construct(){
        if($this->DBHelper === null){
            $this->DBHelper = new DbHelper($this->DBConf);
        }
    }
    
    private function chkImg($img){
        $ext = $this->getFileExt($img);
        if(empty($ext) || !in_array($ext, self::$ImgExtArray)){
            return false;
        }
    }
    
}
