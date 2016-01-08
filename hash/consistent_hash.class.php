<?php
class Consistent_Hash{

    private static $_instance   = null;

    private $_nodes             = array();

    // 单例
    public function getInstance($nodes = array()){
        if(empty($nodes) || !is_array($nodes)){
            throw new Exception('传入参数错误');
        }

        if(self::$_instance === null){
            self::$_instance = new self($nodes);
        }
        return self::$_instance;
    }

    private function __construct($nodes){
        $this->_loadNodes($nodes);
    }

    // 通过time33算法算出字符串的hash值, 不能重复
    public function getHash($string = ''){
        if(empty($string)) return false;

        $md5    = md5($string);
        $hash   = 0;
        $length = strlen($string);
        for($i = 0; $i < $length; $i++){
            $hash = ($hash << 5) + $hash + ord($md5[$i]);
        }
        
        // 0x7FFFFFFF int 最大值
        return $hash & 0x7FFFFFFF;
    }

    // 将所有的item生成hash值, 分布在一个圆圈上
    private function _loadNodes($nodes = array()){
        $keys   = array_keys($nodes);
        foreach($keys as $key){
            $this->_nodes[$key] = $this->getHash($key);
        }
        asort($this->_nodes);
    } 

    // 取得key所在的服务器
    public function getRedisServerConfig($key){
        if(empty($this->_nodes)) return array();
        
        $hash = $this->getHash($key);
        foreach($this->_nodes as $index => $number){
            if($hash <= $number){
                return $index;
            } 
        }
        $keys = array_keys($this->_nodes);
        return !empty($keys) ? $keys[0] : false;
    }

    // 返回全部的node
    public function getNodes(){
        return $this->_nodes;
    }

}

$redis_config = array(
    'server_1' => array('hosts' => '127.0.0.1', 'port' => 6379),
    'server_2' => array('hosts' => '127.0.0.1', 'port' => 6380),
    'server_3' => array('hosts' => '127.0.0.1', 'port' => 6381)
);

$key = 'email';
$consistent_hash    = Consistent_Hash::getInstance($redis_config);
$redis_config       = $consistent_hash->getRedisServerConfig($key);
print_r($consistent_hash->getNodes());
echo PHP_EOL;
echo $consistent_hash->getHash($key) . PHP_EOL;
echo $redis_config . PHP_EOL;
