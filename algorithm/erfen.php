<?php
function erfen($array, $value, $low, $high){
	if($low <= $high){
		$mid = ceil(($low + $high)/2);
		if($array[$mid] == $value){
			return $mid;
		}elseif($array[$mid] >= $value){
			return erfen($array, $value, $low, $mid);
		}else{
			return erfen($array, $value, $mid, $high);
		}
	}
	return false;
}

$array = array(1, 5, 8, 75, 98, 105, 253, 541, 565, 875, 986, 1205);
$count = count($array);
$value = 875;
$key = erfen($array, $value, 0, $count);
echo sprintf("key\t%u\tvalue\t%s", $key, $array[$key]);
?>