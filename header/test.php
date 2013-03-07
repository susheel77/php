<?php
if(file_exists("./header.class.php")) include_once("./header.class.php");
$time = time() + 100;
$request = Header::getInstance();
$request->setCacheByController(100);
$request->setCacheByExpire(100);
$request->setCacheByLastModify($time);
?>
<div style='text-align:center; margin: 50 auto; font-size:30px; font-weight:bolder;'>
    my name is zhanglei
</div>