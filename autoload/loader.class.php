<?php
/**
 * @author zhanglei <zhanglei19881228@sina.com>
 * @description 自动加载类, 加载php文件夹的所谓类文件
 * @date 2014-07-15
 */
class Loader{
    
    private static $_classDir = array();
    private static $_folder = "..";
    
    private static function getFolders(){
        $handle = opendir(self::$_folder);
        while(false !== ($file = readdir($handle))){
            if($file != '.' && $file != '..'){
                $dir = self::$_folder . DIRECTORY_SEPARATOR . $file;
                if(is_dir($dir)){
                    self::$_classDir[] = $dir;
                }
            }
        }
    }
    
    public static function loadClass($classname){
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
