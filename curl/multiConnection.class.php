<?php
class MultiConnection{

    private static $class = null;
    private $cache = array(
        'debug'      => true,
        'dir'        => './cache',
        'prefix' => 'curl'
    );
    private $multi = null;

    private function __construct($cache = array()){
        if(!is_array($cache)){
            throw new Exception('cache conf must be array');
        }
        if($cache) $this->cache = $cache;
        if(!file_exists($this->cache['dir'])) mkdir($this->cache['dir'], 0777);
    }
    
    // 通过url得到缓存文件的filename
    public function getCacheFilename($url){
        return $this->cache['dir'] . '/' . md5($this->cache['prefix'] . $url) . '.log';
    }
    
    /**
     * @description 通过url得到缓存文件, 如果没有缓存文件, 则写入缓存文件
     * @param array $urls
     * @param type $iscache
     * @return url对应缓存文件的数组
     */
    public function getCache(array $urls, $iscache = false){
        if(!is_array($urls)) $urls = array($urls);
        $is_exists = true;
        $filearr = array();
        foreach($urls as $url){
            $filename = $this->getCacheFilename($url);
            if(!file_exists($filename)){
                $is_exists = false;
                break;
            }
            $filearr[] = $filename;
        }
        if(!$is_exists) $filearr = $this->curlmulti($urls, $iscache);
        return $filearr;
    }

    /**
     * @param $urls array
     *     所有的url, 数组, curl多线程采集
     * @param type $iscache
     *     由于采集的调试, 可能多次运行程序, 可能导致源网址采取防采集措施, 故采集至cache中
     * @return type array
     *     如果iscache = true, 返回所有缓存的文件
     *     否则, 返回所有url的内容
     */
    public function curlmulti($urls, $iscache = false){
        if(count($urls) > 20) throw new Exception('The thread is more than the limit');
        $this->multi = curl_multi_init();
        foreach($urls as $key => $url){
            $conn[$key] = curl_init($url);
            curl_setopt($conn[$key], CURLOPT_RETURNTRANSFER, 1);
            curl_multi_add_handle($this->multi, $conn[$key]);
        }

        $active = null;
        do{
            $batch_curl_res = curl_multi_exec($this->multi, $active);
        }while($batch_curl_res == CURLM_CALL_MULTI_PERFORM);


        while($active && $batch_curl_res == CURLM_OK){
            if(curl_multi_select($this->multi) != -1){
                do{
                    $batch_curl_res = curl_multi_exec($this->multi, $active);
                }while($batch_curl_res == CURLM_CALL_MULTI_PERFORM);
            }
        }

        if($batch_curl_res != CURLM_OK){
            throw new Exception('curl multi exec batch resource is failed');
        }
 
        $returns = array();
        foreach($urls as $key => $url){
            if(!curl_error($conn[$key])){
                $content = curl_multi_getcontent($conn[$key]);
                $filename = $this->getCacheFilename($url);
                if($iscache){
                    $result = $this->handleCache($filename, $content);
                    if(!$result) throw new Exception('write content to cache is failed');
                    $returns[] = $result;
                }else{
                    $returns[] = $content;
                }
            }else{
                throw new Exception('curl every url is failed');
            }
            curl_multi_remove_handle($this->multi, $conn[$key]);
            curl_close($conn[$key]);
        }
        return $returns;
    }

    /**
     * @param type $filename
     *     缓存文件的文件名称
     * @param type $content
     *     要写入缓存文件的内容
     * @return $filename
     *     返回缓存文件的名称
     */
    private function handleCache($filename, $content){
        if(!isset($this->cache['dir'])){
            throw new Exception('cache dir is not set');
        }
        if(!isset($filename)){
            throw new Exception('cache fileprefix is not set');
        }
        $fp = fopen($filename, 'w+');
        fwrite($fp, $content);
        fclose($fp);
        return $filename;
    }
    
    /**
     * @param type $regexp
     *     正则表达式
     * @param type $content
     *     需要的字符串
     * @return type array
     *     返回数组
     */
    public function preg($regexp, $content){
        $matches = null;
        preg_match_all($regexp, $content, $matches);
        return $matches;
    }
    
    /**
     * @param $incharset 原字符集
     * @param $outcharset 需要修改的字符集
     * @param $string 需要转化编码的字符串
     * @return $string 转换后的字符串
     */
    public function striconv($string, $in_charset = 'gb2312', $out_charset = 'utf-8'){
        $new_string = iconv($in_charset, $out_charset, $string);
        return $new_string;
    }

    public static function getInstance($cache = array()){
        if(self::$class === null){
            self::$class = new MultiConnection($cache);
        }
        return self::$class;
    }

}
?>