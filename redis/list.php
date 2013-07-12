<?php

$link = mysql_connect("localhost", "root", "root") or die("can not connect mysql");
mysql_select_db('redis', $link);
mysql_query('set names utf8', $link);

if(file_exists('./inc.php')) include_once('./inc.php');

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
    )engine=myisam default charset=utf8;
 */

while(true){

    $list = $redis->rpop($flag);
    $data = unserialize($list);

    $sql = sprintf("insert into users set username = '%s', password = '%s', sex = '%s', email = '%s', created_time = '%s'", $data['username'], $data['password'], $data['sex'], $data['email'], date('Y-m-d H:i:s'));

    // 此处需要做unique的判断, 由于时间原因, 省略了。list.php需要时刻运行着, 以保证不断的从redis取出数据交给mysql, 减少mysql的并发, 有必要去写个shell的守护进程去看护

    try{
        $result = mysql_query($sql);
        if(!$result) echo mysql_error();
    }catch(Exception $e){
        throw new Exception("error is throwed when insert to the mysql"); 
    }

}
?>