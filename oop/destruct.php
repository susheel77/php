<?php
class Destruct{

	private $name;

	public function __construct($name){
		$this->name = $name;
	}

	public function say(){
		echo $this->name;
	}

	public function __destruct(){
		echo "unset" . $this->name;
	}

}

$d1 = new Destruct('张磊');
$d2 = new Destruct("adele");
echo $d1->say();
echo "\r\n";
echo $d2->say();
?>
