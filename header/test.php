<?php
if(file_exists("./header.class.php")) include_once("./header.class.php");

$request = ResponseHeader::getInstance();
$request->setCacheByController(100);
$request->setCacheByExpires(100);
$request->setCacheByLastModify(100);

?>
<div style='text-align:center; margin: 50 auto; font-size:30px; font-weight:bolder;'>
    my name is zhanglei a
</div>