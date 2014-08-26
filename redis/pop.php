<?php
if(file_exists('./inc.php')){
	include_once('./inc.php');
}else{
	throw new Exception('inc php is not exists');
}
set_time_limit(3600);
$start = microtime('sec');
/*
    create table users(
        uid int unsigned not null auto_increment comment '自增长ID',
        username varchar(30) not null comment '用户名',
        password varchar(50) not null comment '用户密码',
        sex varchar(10) not null comment '用户性别',
        email varchar(30) not null comment '用户邮箱',
        created_time timestamp not null default current_timestamp comment '用户注册时间',
        primary key (uid),
        unique key (username),
        unique key (email)
    )engine=innodb default charset=utf8;
 */
$table = 'users';
$status = true;
while($status){
    $list = $redis->rpop($flag);
    $data = unserialize($list);
	if(empty($data)){
		$status = false;
	}

    // 此处需要做unique的判断, 由于时间原因, 省略了。list.php需要时刻运行着, 以保证不断的从redis取出数据交给mysql, 减少mysql的并发, 有必要去写个shell的守护进程去看护
	//$result = $db->insert($table, $data);
}
$end = microtime('sec');
echo $end - $start;

/*
 * 短连接	mysqli_connect	41.243359088898
 * 长连接	new mysqli		39.714272022247
 * 去掉try	new mysqli		37.023116827011
 * 去掉插入 无				0.062004089355469
 */
?>