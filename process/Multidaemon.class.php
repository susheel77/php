<?php
/**
 * @author zhanglei <zhanglei19881228@sina.com>
 * @date 2015-06-04 17:00
 * @description php多进程, 从此之后错误我都用throw new Exception, 哈哈
 */
class Multidaemon
{
    // 单例
    private static $_instance   = null;
    
    // 配置文件的模板
    private $_conf_fields       = array(
        'class', 'method', 'params', 'counts'
    );
    
    // 配置文件
    private $_conf              = array();
    
    // 错误代码
    private $_errors            = array(
        'system'    => array('code' => 100002, 'msg' => '系统错误'),
        'params'    => array('code' => 100003, 'msg' => '参数错误'),
        'class'     => array('code' => 100004, 'msg' => '类不存在'),
        'method'    => array('code' => 100005, 'msg' => '方法不存在')
    );
    
    // 实例化
    private function __construct($conf)
    {
        $this->_conf = $conf;
        $this->_checkConf();
        $this->_execute();
    }
    
    /**
     * 检查配置文件是否错误
     * @return boolean
     */
    private function _checkConf()
    {
        foreach ($this->_conf_fields as $field)
        {
            if (!isset($this->_conf[$field]))
            {
                $this->_throw_error('params');
            }
        }
        return true;
    }
    
    /**
     * 抛出异常错误
     * @param type $param 错误的key see $this->_errors
     * @throws Exception
     */
    private function _throw_error($param)
    {
        $errors = !empty($this->_errors[$param]) ? $this->_errors[$param] : $this->_errors['system'];
        throw new Exception($errors['msg'], $errors['code']);
    }
    
    private function _execute()
    {
        $reflection_class   = new ReflectionClass($this->_conf['class']);
        
        if ($reflection_class->hasMethod('getInstance'))
        {
            $_m = $reflection_class->getMethod('getInstance');
            $object = $_m->invoke(null);
        }
        else
        { 
            $object = $reflection_class->newInstance($reflection_class);
        }
        
        if (!is_object($reflection_class))
        {
            $this->_throw_error('class');
        }
        

        if (!$reflection_class->hasMethod($this->_conf['method']))
        {
            $this->_throw_error('method');
        }
        
        $method = $reflection_class->getMethod($this->_conf['method']);
        $method->invokeArgs($object , array('key' => 'a'));
        return true;
    }
    
    /**
     * 单例模式
     * @param type $conf daemon配置文件
     * @return type
     */
    public static function getInstance($conf = array())
    {
        if (self::$_instance === null)
        {
            self::$_instance = new Multidaemon($conf);
        }
        return self::$_instance;
    }
    
}