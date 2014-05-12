<meta charset='gbk' />
<?php
set_time_limit(3600);
error_reporting(7);
include_once('../mysql/DBHelper.class.php');

$conf = array(
    'host' => 'localhost',
    'user' => 'root',
    'pass' => 'root',
    'db'   => 'demo'
);

$filename = './cache/content.log';
$href_filename = './cache/href.log';
function fput($filename, $content){
	$fp = fopen($filename, 'w+');
	fwrite($fp, $content);
	fclose($fp);
}

$db = DbHelper::getInstance($conf);

$hrefs_content = file_get_contents($href_filename);
if(empty($hrefs_content)){
	$url = 'http://sports.sina.com.cn/g/premierleague/';
	$content = file_get_contents($url);
	preg_match_all('/<li>\s*<a\s*href=(.*shtml)\s*class="fgrey"\s+target=_blank>(.*)<\/a>(.*)<\/li>/', $content, $matches);
	$hrefs = $matches[1];
	fput($href_filename, implode("\r\n", $hrefs));
}

$hrefs = explode("\r\n", $hrefs_content);

$preg = array(
	'title'			=> '/<h1\s+id="artibodyTitle">(.*)<\/h1>/',
	'created_time'	=> '/<span id="pub_date">(.*)<\/span>/',
	'author'		=> '/<span id="media_name"><a(.*)>(.*)<\/a>/',
	'author1'		=> '/<span id="media_name"><font(.*)>(.*)<\/font>/',
	'content'		=> '/<div class=(.*) id="artibody">(.*)<!--\s+publish_helper_end\s+--\>/Uis'
);

foreach($hrefs as $href){
	$main_content = file_get_contents($filename);
	if(empty($main_content)){
		$main_content = file_get_contents($href);
		fput($filename, $main_content);
	}
	preg_match_all($preg['title'], $main_content, $title_matches);
	$data['title'] = $title_matches[1][0];
	preg_match_all($preg['created_time'], $main_content, $created_time_matches);
	$data['created_time'] = $created_time_matches[1][0];
	preg_match_all($preg['author'], $main_content, $author_matches);
	if(empty($author_matches[2][0])){
		preg_match_all($preg['author1'], $main_content, $author_matches);
	}
	$data['author'] = $author_matches[2][0];
	preg_match_all($preg['content'], $main_content, $content_matches);
	$data['content'] = $content_matches[2][0];

	foreach($data as $key => $value){
		$data[$key] = iconv('gbk', 'utf-8', $data[$key]);
	}

	$record = $db->readOne('news', array('title' => $data['title']), 'id');
	if(!$record && !empty($data['title']) && !empty($data['content']) && !empty($data['author'])){
		$result = $db->write('news', $data);
		$errors = $db->getError();
		if(!empty($errors)) fput('./cache/error.log', $errors['error']);
	}
	fput($filename, '');
}
?>