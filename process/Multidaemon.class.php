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
        'method'    => array('code' => 100005, 'msg' => '方法不存在'),
        'fork'      => array('code' => 100006, 'msg' => 'fork方法出错')
    );
    
    // 实例化
    private function __construct($conf)
    {
        $this->_conf = $conf;
        $this->_checkConf();
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
    
    /**
     * 执行
     * @return boolean
     */
    public function execute()
    {
        // fork子进程处理数据
        for ($i = 0; $i < $this->_conf['counts']; $i++)
        {
            $pid = pcntl_fork();
            
            if ($pid < 0)
            {
                $this->_throw_error('fork');
            }
            elseif ($pid)
            {
                // 父进程
                //pcntl_wait($status);
            }
            else
            {
                // 利用php反射机制, 调用$this->_conf传过来的方法
                $reflection_class   = new ReflectionClass($this->_conf['class']);
                
                // 实例化传过来的类
                if ($reflection_class->hasMethod('getInstance'))
                {
                    $_m = $reflection_class->getMethod('getInstance');
                    $object = $_m->invoke(null);
                }
                else
                { 
                    $object = $reflection_class->newInstance($reflection_class);
                }
                
                // 验证类文件以及方法是否存在
                if (!is_object($reflection_class))
                {
                    $this->_throw_error('class');
                }
                if (!$reflection_class->hasMethod($this->_conf['method']))
                {
                    $this->_throw_error('method');
                }

                // 子进程, 执行完子进程立刻exit, 参照readme
                $method = $reflection_class->getMethod($this->_conf['method']);
                $method->invokeArgs($object , $this->_conf['params']);
                exit;
            }
        }
        
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
