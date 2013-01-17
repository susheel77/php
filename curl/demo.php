<?php
set_time_limit(3600);
error_reporting(7);
/**
 * 由于时间原因, 更多的报错没有处理, 有时间再去处理那些错误报告
 * 缓存文件取名的规则
 * 根据md5(prefix+url)来当做文件的名称, 这样通过每个url就能找到每个url所对应的缓存文件, 则不需要每次都远程调用
 */
include_once('./multiConnection.class.php');
include_once('../mysql/DBHelper.class.php');

$conf = array(
    'host' => 'localhost',
    'user' => 'root',
    'pass' => 'root',
    'db'   => 'demo'
);
$db = DbHelper::getInstance($conf);

$url = array(
    0 => 'http://news.163.com/rank/'
);
$cache = array(
    'dir'       => './cache',
    'prefix'    => 'curl'
);

/**
 * 所有的正则表达式
 * 所有more(更多)的连接
 * href 进入more连接后, 抓取所有新闻标题
 */
$regexp = array(
    'more' => '/<div\s+class="more"><a\s+href="(.*)">(.*)<\/a>\s*<\/div>/Uims',
    'href' => '/<td\s+class="(.*)">\s*<span>(.*)<\/span>\s*<a\s+href="(.*)">(.*)<\/a>\s*<\/td>/'
);

$news_exp = array(
    'title'                  => '/<h1\s*id="h1title"\s*class="ep-h1">(.*)<\/h1>/Uims',
    'summary'                => '/<p\s+class="ep-summary">(.*)<\/p>/Uims',
    'author'                 => '/ <div\s+class="ep-source cDGray">(.*)<\/a>\s*：\s+(.*)<\/span>\s*<span\s+class="ep-editor">/Uims',
    'pic'                    => '',
    'content'                => '/<div\s+id="endText">(.*)<\/div>/Uims',
    'resource_created_time'  => '/<div\s+class="ep-info\s+cDGray">\s*<div\s+class="left">(.*)[^\d|\-|:|\s](.*)<a\s+(.*)>(.*)<\/a>/Uims'
);

try{
    $curl = MultiConnection::getInstance($cache);
    $filearr = $curl->getCache($url, true);
    if(is_array($filearr)){
        foreach($filearr as $file){
            $content = file_get_contents($file);
            $matches = $curl->preg($regexp['more'], $content);
        }
    }
    $more_urls = $curl->getCache($matches[1], true);
    $hrefs = array();
    if(is_array($more_urls)){
        foreach($more_urls as $more_url){
            $content = file_get_contents($more_url);
            $matches = $curl->preg($regexp['href'], $content);
            foreach($matches[3] as $match){
                $hrefs[] = $match;
            }
        }
    }
    // 因为所有的连接太多, 不可能拉出count(hrefs)的线程去远程采集
    $chunk_hrefs = array_chunk($hrefs, 20, true);
    $content = array();
    foreach($chunk_hrefs as $chunk){
        $content = $curl->curlmulti($chunk, false);
        foreach($content as $c){
            $titles = $curl->preg($news_exp['title'], $c);
            $title = $curl->striconv($titles[1][0]);
            $summarys = $curl->preg($news_exp['summary'], $c);
            $summary = $curl->striconv($summarys[1][0]);
            $resource_created_time = $curl->preg($news_exp['resource_created_time'], $c);
            $created_time = $resource_created_time[1][0];
            $resource = $curl->striconv($resource_created_time[4][0]);
            $texts = $curl->preg($news_exp['content'], $c);
            $_text = preg_replace('/<iframe(.*)>\s*<\/iframe>/', ' ', $texts[1][1]);
            $text = $curl->striconv($_text);
            $array = array(
                'title' => $title,
                'summary' => $summary,
                'resource' => $resource,
                'content' => $text,
                'created_time' => $created_time
            );
            $db_results = $db->write('news', $array, false, false);
            //echo $db_results;die;
            if(!$db_results) exit(mysql_error());
        }
    }
}catch(Exception $e){
    echo $e->getMessage();
}
?>