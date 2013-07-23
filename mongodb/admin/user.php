<meta charset='utf-8' />
<?php

if(file_exists('../mongodb.class.php')) include_once('../mongodb.class.php');

$db = Db::getInstance();
$connection = $db->getCollection();

$users = $connection->selectCollection('users');
$bottle = $connection->selectCollection('bottle');
$bottle_action = $connection->selectCollection('bottle_action');

$status = true;
if(empty($_COOKIE['user_id']) || empty($_COOKIE['user_name'])){
	$status = false;
}

$current = $users->findOne(array('_id' => new MongoId($_COOKIE['user_id'])));

if(empty($current)) $status = false;

if(!$status){
	echo "<script>";
	echo "location.href='www.mongodb.com/front/user.php'";
	echo "</script>";
}

if($current['name'] != 'zhanglei'){
	echo "<script>";
	echo "alert('你没有权限')";
	echo "location.href='www.mongodb.com/front/user.php'";
	echo "</script>";
}

$user_lists = $users->find(array('name' => array('$ne' => 'zhanglei')));

?>
<div style='font-size: 20px; font-weight:bolder; color: red; letter-spacing: 6px; margin-bottom: 10px;'>用户表</div>
<table border='1' style='border-collapse: collapse'>
<tr>
	<th>用户名</th>
	<th>用户密码</th>
	<th>用户email</th>
	<th>用户性别</th>
	<th>用户注册时间</th>
</tr>
<?php while($list = $user_lists->getNext()): ?>
<tr>
	<td><?php echo $list['name']; ?></td>
	<td><?php echo $list['pass']; ?></td>
	<td><?php echo isset($list['email']) ? $list['email'] : '无'; ?></td>
	<td><?php echo isset($list['sex']) ? $list['sex'] : '无'; ?></td>
	<td><?php echo isset($list['created_time']) ? $list['created_time'] : '无'; ?></td>
</tr>	
<?php endwhile; ?>
</table>

<?php

$bottle_lists = $bottle->find();

?>
<div style='font-size: 20px; font-weight: bolder; color: red; letter-spacing: 4px; margin-bottom: 10px; margin-top: 20px;'>漂流瓶类型</div>
<table style="border-collapse: collapse" border=1>
<tr>
	<th>漂流瓶类型</th>
	<th>漂流瓶描述</th>
</tr>
<?php while($bottle_list = $bottle_lists->getNext()): ?>
<tr>
	<td><?php echo $bottle_list['name']; ?></td>
	<td><?php echo $bottle_list['description']; ?></td>
</tr>
<?php endwhile; ?>
</table>

<?php

$bottle_action_lists = $bottle_action->find();

?>

<div style='font-size: 20px; font-weight: bolder; color: red; letter-spacing: 6px; margin-bottom: 10px; margin-top: 20px;'>漂流瓶</div>
<table style='border-collapse: collapse' border=1>
<tr>
	<th>发送人</th>
	<th>收件人</th>
	<th>漂流瓶类型</th>
	<th>漂流瓶内容</th>
</tr>
<?php while($bottle_action_list = $bottle_action_lists->getNext()): ?>
<tr>
	<td><?php $user_id_from_arr = MongoDBRef::get($bottle_action->db, $bottle_action_list['user_id_from']); echo $user_id_from_arr['name']; ?></td>
	<td><?php $user_id_to_arr = MongoDBRef::get($bottle_action->db, $bottle_action_list['user_id_to']); echo $user_id_to_arr['name']; ?></td>
	<td><?php $bottle_arr = MongoDBRef::get($bottle->db, $bottle_action_list['bottle_id']); echo $bottle_arr['name']; ?></td>
	<td><?php echo $bottle_action_list['content']; ?></td>
</tr>
<?php endwhile; ?>
</table>

