<?php
// 观察者接口类
interface ObserverInterface{
	public function addObserver($observers);
}

// 用户接口类
interface UserInterface{
	public function getName($params);
}

// 观察者类
class Observer implements ObserverInterface{
	private $_observer = array();
	
	public function addObserver($observer){
		$this->_observer[] = $observer;
	}

	public function userOperation($params){
		foreach($this->_observer as $key => $obj){
			$obj->getName($params);
		}
	}
}

// 用户类, 被观察者类
class User implements UserInterface{
	public function getName($params){
		echo "params: " . $params;
	}
}

$observer = new Observer();
$observer->addObserver(new User());
$observer->userOperation('aaa');
?>
