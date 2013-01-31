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
    0 => 'http://sports.sina.com.cn/nba/'
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
    'more' => '/<div\s+class="tab\s+tabnews\s+tab690"(.*)>\s*<p\s+class="current">\s*<a\s+href="(.*)"\s+target="_blank">(.*)<\/a>\s*<\/p>.?/Uims',
    'thref' => '/<div\s+id="right">(.*)<a\s+href="(.*)"\s+target="_blank">(.*)<\/a><br><br><\/div>/ims',
    'href' => '/<a\s+href="(.*)"\s+target="_blank">(.*)<\/a>/Uims'
);

$news_exp = array(
    'title'                  => '/<h1\s+id="artibodyTitle">(.*)<\/h1>/Uims',
    'summary'                => ' ',
    'author'                 => '/<a\s+class="ent1\s+fred"\s+href="(.*)"\s+target="_blank"\s+data-sudaclick="media_name">(.*)<\/a>/Uims',
    'pic'                    => '',
    'content'                => "/<!--\s+publish_helper(.*)\s+-->(.*)<!--\s+publish_helper_end\s+-->/Uims",
    'created_time'           => '/<span\s+id="pub_date">(.*)<\/span>/Uims'
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
    $more_urls = $curl->getCache($matches[2], true);
    $hrefs = array();
    if(is_array($more_urls)){
        foreach($more_urls as $more_url){
            $content = file_get_contents($more_url);
            $matches = $curl->preg($regexp['thref'], $content);
            $_matches = $curl->preg($regexp['href'], $matches[1][0]);
            foreach($_matches[1] as $match){
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
            $created_times = $curl->preg($news_exp['created_time'], $c);
            $created_time = $curl->striconv($created_times[1][0]);
            $created_time =  preg_replace_callback(
                '/(\d+)[^\d]*(\d+)[^\d]*(\d+)[^\d]*(.*)/', 
                function($matches)use($created_time){
                    return sprintf("%s-%s-%s %s", $matches[1], $matches[2], $matches[3], $matches[4]);
                },
                $created_time
            );
            $authors = $curl->preg($news_exp['author'], $c);
            $resource = $author = $curl->striconv($authors[2][0]);
            $texts = $curl->preg($news_exp['content'], $c);
            $text = $curl->striconv($texts[2][0]);
            $array = array(
                'title' => $title,
                'author' => $author,
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