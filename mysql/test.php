<?php

if(file_exists('./DbHelper.class.php')) include_once('./DbHelper.class.php');

$conf = array(
    'host'      => 'localhost',
    'user'      => 'root',
    'pass'      => 'root',
    'db'        => 'gamestat',
    'character' => 'utf8'
);

$db_helper = DbHelper::getInstance($conf);

$write_data = array(
    'logtime'           => '2012-12-24 00:00:00',
    'gameid'            => 310057,
    'registercount'     => 500,
    'registeripcount'   => 500,
    'entercount'        => 500,
    'enteripcount'      => 500,
    'activecount'       => 50,
    'activeipcount'     => 500,
    'dau'               => 500,
    'duu'               => 500,
    'thirdduu'          => 500,
    'wuu'               => 500,
    'muu'               => 500,
    'totalcount'        => 500,
    'todaymoney'        => 500,
    'payercount'        => 500,
    'tradecount'        => 500
    
);

$table = 'ww_game_behavior_log';

// insert operation
//$result = $db_helper->write($table, $write_data, false, 0);

// delete operation
//$result = $db_helper->delete($table, array('registercount' => 50), 1);


$update_data = array(
    'logtime'           => '2012-12-25 23:59:59',
    'registercount'     => 100,
    'registeripcount'   => 2000
);

$update_where = array(
    'wuu'   => 500
);

$update_where = "wuu = 50";

$result = $db_helper->write($table, $update_data, $update_where, 0);


$data = array(
    'logtime'   => '2012-12-25 23:59:59',
    'wuu'       => 50
);

$fields = array('id', 'logtime', 'registercount');
$result = $db_helper->readOne($table, $data, $fields, '', 0);
print_r($result);
?>