<?php
if(file_exists('./inc.php')){
	include_once('./inc.php');
}else{
	throw new Exception('inc.php is not exists');
}

$num = 500;
for($i = 0; $i <= $num; $i++){  
    $data['sex'] = array_rand(array("man" => 1, "woman" => 2));
    $strings = array_flip(range("a", "z"));
    $prefix = implode(array_rand($strings, 8), "");
    $data['email'] = $prefix . "@sina.com.cn";
    $data['username'] = $prefix . $i;
    $data['password'] = md5($data['username']);
    $redis->lpush($flag, serialize($data));
}
?>