<?php
/**
 * @author zhanglei <zhanglei19881228@sina.com>
 * @date 2014-06-12 16:00
 * @brief 观察者模式, 先将注册观察者, 状态发生改变后, 由主题通知众多的观察者
 */
interface ObserverInterface{
   
    public function addObserver($observer);
    
    public function notity($message);
}

class Observer implements ObserverInterface{
    
    private $_observer = array();
    
    // 注册观察者
    public function addObserver($observer){
        $this->_observer[] = $observer;
    }
    
    // 主题状态发生改变, 通知已经注册的观察者
    public function notity($message){
        if(isset($this->_observer) && !empty($this->_observer) && is_array($this->_observer)){
            foreach($this->_observer as $observer){
                $observer->logger($message);
            }
        }
    }
    
}

interface Web{
    
    public function logger($message);
    
}

class Apache implements Web{

    public function logger($message){
        echo get_class() . ": " . $message . "<br />";
    }
}

class Nginx implements Web{
    
    public function logger($message){
        echo get_class() . ": " . $message . "<br />";
    }
    
}

/* 以下测试 */
$observer = new Observer;
$observer->addObserver(new Apache);
$observer->addObserver(new Nginx);
$observer->notity('design pattern');
?>