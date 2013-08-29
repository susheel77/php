<?php
if(file_exists("./header.class.php")) include_once("./header.class.php");

/* 当前时间 大于 If_Modified_Since + 缓存时间 时候, 缓存已经过期, 需要重新设置缓存, 否则304 */

$if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : 0;
$response = ResponseHeader::getInstance();

if($if_modified_since){
    $is_cache = ((time()+8*3600) - strtotime($if_modified_since)) > 10 ? true : false;
    if($is_cache){
        // 需要重新设置缓存
        $response->setPragma();
        $response->setCacheByController(10);
        $response->setCacheByExpires(10);
        $response->setCacheByLastModify(10);
    }else{
        $response->setHeaderStatus(304);
    }
}else{
    $response->setCacheByLastModify(10);
}

?>
<div style='text-align:center; margin: 50 auto; font-size:30px; font-weight:bolder;'>
    my name is zhanglei a
</div>