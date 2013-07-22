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

// 漂流瓶类型表
$bottle = $connection->selectCollection('bottle');

// 漂流瓶动作表
$bottle_action = $connection->selectCollection('bottle_action');

if($act == 'play'){
	$id = trim($_GET['id']);
	$_id = new MongoId($id);
	$current_bottle = $bottle->findOne(array('_id' => $_id));
	if(empty($current_bottle)) die('漂流瓶不存在');
?>
	<form method='post' action='bottle.php?act=playtodo'>
		<?php echo $current['name']; ?> 选择的是 <?php echo $current_bottle['name']; ?>
		<input name='bottle_id' type='hidden' value='<?php echo $current_bottle["_id"]; ?>' /><br /><br />
		漂流瓶内容: <textarea name='content' rows=2 cols=20></textarea><br /><br />
		<input name='submit' value='扔出去' type='submit' />
	</form>
<?php
}elseif($act == 'playtodo'){
	$data['bottle_id'] = MongoDBRef::create('bottle', new MongoId(trim($_POST['bottle_id'])));
	$data['content'] = htmlspecialchars(addslashes(trim($_POST['content'])));
	$data['user_id_from'] = MongoDBRef::create('users', $current['_id']);
	$users_list = $users->find();
	$userslists = array();
	foreach($users_list as $key => $list){
		$userslists[] = $list['_id'];
	}
	$rand_key = array_rand($userslists, 1);
	$data['user_id_to'] = MongoDBRef::create('users', $userslists[$rand_key]);
	$data['created_time'] = date('Y-m-d H:i:s');
	$result = $bottle_action->insert($data);
	if($result){
		echo "<script>";
		echo "location.href='bottle.php'";
		echo "</script>";
	}
}else{
	$user_id_to = $current['_id']->{'$id'};
	$where = array('user_id_to' => MongoDBRef::create('users', new MongoId($user_id_to)));
	$count = $bottle_action->count($where);
	$lists = $bottle_action->find($where);
	$bottle_lists = $bottle->find();
?>
	欢迎 <?php echo $current['name']; ?>, 亲, 您总共有 <?php echo $count; ?> 个漂流瓶<br /><br />
	<div style='color:red'>
	<?php while($list = $lists->getNext()): ?>
		发送人：<?php $user_from = MongoDBRef::get($bottle_action->db, $list['user_id_from']); echo $user_from['name']; ?><br />
		送达时间：<?php echo $list['created_time']; ?><br />
		漂流瓶内容：<?php echo $list['content']; ?><br />
	<?php endwhile; ?>
	</div>
	<br /><br /> 
	<?php foreach($bottle_lists as $id => $list): ?>
	<?php echo $list['name']; ?>&nbsp;&nbsp;<a href='bottle.php?act=play&id=<?php echo $list["_id"]; ?>'>扔瓶子</a><br /><br />
	<?php endforeach; ?>
<?php
}
?>
