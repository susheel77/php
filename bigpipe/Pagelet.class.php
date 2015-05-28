<?php
/**
 * pagelet的基类
 * 负责加载配置文件
 * 负责查找骨架
 * 负责查找所有小的pagelet页面
 * 负责将数据传递给render类, 让render类去渲染所有的pagelet
 * @author zhanglei <zhanglei19881228@sina.com>
 * @date 2015-05-28 17:30
 */
abstract class Pagelet
{
    // 配置文件内容, 只第一次加载
    private     $_configs   = array();
    
    // 是否是骨架
    protected   $skeleton   = false;
    
    // pagelet的名称
    protected   $name       = '';
    
    // pagelet的模板名称
    protected   $tpl        = '';
    
    // 骨架下所有的pagelets
    private     $_children  = array();
    
    // 每个pagelet(包括骨架)所需要准备的数据
    private     $_data      = array();

    /**
     * 负责加载配置文件
     */
    public function __construct()
    {
        $this->_configure();
    }
    
    /**
     * 引入配置文件
     */
    private function _configure()
    {
        if (empty($this->_configs))
        {
            $configs = include_once(CONFIG . DS . 'config.php');
            // 如果是骨架, 并且在配置中存在, 则将配置文件有关$this->name的信息记录到$this->_configs中
            if ($this->getSkeleton() && isset($configs[$this->name]))
            {
                $this->configs = $configs[$this->name];
            }
            else
            {
                $this->configs = array();
            }
        }
    }
    
    public function getPagelet()
    {
        
    }
    
    /**
     * 得到是否是骨架
     * @return type boolean
     */
    public function getSkeleton()
    {
        return $this->skeleton;
    }
    
    public function prepareData();
    
    
}