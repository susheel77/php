<?php
/**
 * @author zhanglei <zhanglei19881228@sina.com>
 * @description 自动加载类, 加载php文件夹的所谓类文件
 * @date 2014-07-15
 */
class Loader{
    
    private static $_classDir = array();
    private static $_folder = "";
    
    private static function getFolders($dir = ''){
        $folder = empty($dir) ? self::$_folder : $dir;

        $handle = empty($dir) ? opendir($folder) : opendir($dir);
        while(false !== ($file = readdir($handle))){
            if($file != '.' && $file != '..'){
                $dir = $folder . DIRECTORY_SEPARATOR . $file;
                if(is_dir($dir)){
                    self::$_classDir[] = $dir;
					self::getFolders($dir);
                }
            }
        }
    }
    
    // 防止linux windows以及其他人的目录不一致, 用相对于__FILE__的路径设置self::$_folders
    public static function setFolders()
    {
        self::$_folder = dirname(dirname(__FILE__));
    }
    
    public static function loadClass($classname){
        self::setFolders();
        self::getFolders();
        if(is_array(self::$_classDir) && !empty(self::$_classDir)){
            foreach(self::$_classDir as $dir){
                $filename = $dir . DIRECTORY_SEPARATOR . $classname . '.class.php';
                if(is_file($filename) && file_exists($filename)){
                    require_once($filename);
                }
            }
        }else{
            throw new Exception('class dir is not exists');
        }
    }
    
}
