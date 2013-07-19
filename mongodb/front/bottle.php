<meta charset='utf8' />
<?php
session_start();

if(file_exists('../mongodb.class.php')) include_once('../mongodb.class.php');

$status = true;

if(!isset($_COOKIE['user_name']) || !isset($_COOKIE['user_id'])){
	$status = false;
}


$db = Db::getInstance();
$connection = $db->getCollection();

$users = $connection->selectCollection('users');

$current = $users->findOne(array('_id' => new MongoId($_COOKIE['user_id'])));

if(empty($current)) $status = false;

if(!$status){
	echo "<script>";
	echo "location.href='user.php'";
	echo "</script>";
}


$act = isset($_GET['act']) ? $_GET['act'] : '';

// 漂流瓶类型库
$bottle = $connection->selectCollection('bottle');
if($act == 'play'){
	
}else{
	$bottle_lists = $bottle->find();
?>
	欢迎 <?php echo $current['name']; ?>, 亲 <br /><br /><br /> 
	<?php foreach($bottle_lists as $id => $list): ?>
	<?php echo $list['name']; ?>&nbsp;&nbsp;<a href='bottle.php?act=play&id=<?php echo $list["_id"]; ?>'>扔瓶子</a><br /><br />
	<?php endforeach; ?>
<?php
}
?>
