<meta charset='utf-8' />
<?php

session_start();
if(file_exists('../mongodb.class.php')) include_once('../mongodb.class.php');

$db = Db::getInstance();
$connection = $db->getCollection();

$users = $connection->selectCollection('users');

$act = isset($_GET['act']) ? $_GET['act'] : '';
if($act == 'reg'){
	// 注册模板
?>
	<form action='?act=regtodo' method='post'>
		username: <input name='name' type='text' /><br /><br />
		password: <input name='pass' type='password' /><br /><br />
		email:&nbsp;&nbsp;&nbsp;&nbsp;<input name='email' type='text' /><br /><br />
		sex:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='sex' type='radio' value='man' />man <input name='sex' type='radio' value='woman' />woman<br /><br />
		<input name='submit' type='submit' value='注册' />
	</form>
<?php
}elseif($act == 'regtodo'){
	// 注册
	$data['name'] = addslashes(htmlspecialchars(trim($_POST['name'])));
	$data['pass'] = addslashes(htmlspecialchars(trim($_POST['pass'])));
	$data['email'] = addslashes(htmlspecialchars(trim($_POST['email'])));
	$data['sex'] = trim($_POST['sex']);
	$data['created_time'] = date('Y-m-d H:i:s');

	if(!$data['name']) die('请填写用户名');
	if(!$data['pass']) die('请填写密码');
	if(!$data['email']) die('请填写邮箱');
	if(!$data['sex'] || !in_array($data['sex'], array('man', 'woman'))) die('请选择用户性别');

	$result = $users->insert($data);
	if($result){
		setcookie('user_id', $data['_id'], time() + 3600, '/');
		setcookie('user_name', $data['name'], time() + 3600, '/');
		echo "<script>";
		echo "location.href='bottle.php'";
		echo "</script>";
	}
}elseif($act == 'login'){
	// 登录模板
?>
	<form action='user.php?act=logintodo' method='post'>
		username: <input name='name' type='text' /><br /><br />
		password: <input name='pass' type='pass' /><br /><br />
		<input name='submit' value='登录' type='submit' />
	</form>
<?php
}elseif($act == 'logintodo'){
	// 登录
	$name = htmlspecialchars(addslashes(trim($_POST['name'])));
	$pass = htmlspecialchars(addslashes(trim($_POST['pass'])));
	$current = $users->findOne(array('name' => $name));
	if(!$current) die('用户名不存在');
	if($pass == $current['pass']){
		setcookie('user_id', $current['_id'], time() + 3600, '/');
		setcookie('user_name', $current['name'], time() + 3600, '/');
		echo "<script>";
		echo "location.href='bottle.php'";
		echo "</script>";
	}else{
		die('密码不正确');
	}
}else{
?>
欢迎来到漂流瓶世界. 需要<a href='?act=login'>登录</a>后才能使用漂流瓶. 如果未注册, 请先<a href='?act=reg'>注册</a>
<?php
}
?>
