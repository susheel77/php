<?php
// OOP策略模式
// 接口类
interface Strategy{
	public function filter($record);
}

// 策略倒序
class Desc implements Strategy{
	
	public function filter($array){
		rsort($array);
		return $array;
	}

}

// 策略正序
class Asc implements Strategy{

	public function filter($array){
		sort($array);
		return $array;
	}
}

// 用户类
class Users{

	private $array = array();

	public function __construct($array){
		if(!is_array($array)) throw new Exception('User Class params should be array');
		foreach($array as $value){
			$this->array[] = intval($value);
		}
	}

	public function sort($obj){
		if(is_array($this->array)) return $obj->filter($this->array);
	}

}

$users = new Users(array(4, 7, 1, 60, 58, 40, 34));
$asc = $users->sort(new Asc());
$desc = $users->sort(new Desc());

print_r($asc);

echo "\r\n";

print_r($desc);
?>
