<?php
/**
 * @description redis
 * @author zhanglei <zhanglei19881228@sina.com>
 */

namespace Redis;
use Predis;

class Redis{
    
    private static $class = null;       // 实例化对象
    private $connection;                // redis连接对象
    private $keyprefix = 'redis';       // 存储key前缀
    
    // 构造函数
    private function __construct($conf){
        if($this->checkConf($conf)) throw new Exception('redis conf is error');
        if(file_exists(__DIR__ . '/predis/autoload.php')){
            require_once(__DIR__.'/predis/autoload.php');
            $this->connection = new Predis\Client($conf);
        }else{
            exit('redis system is error');
        }
    }
    
    // 检查传入的conf是否正确
    private function checkConf($conf){
        if(!$conf || !is_array($conf)) return false;
    }
    
    // 增加
    public function set($key, $value){
        return $this->connection->set($this->keyprefix . $key, $value);
    }
    
    // 修改
    public function update($key, $value){
        if($this->get($key)) return $this->set($key, $value);
    }
    
    // 删除
    public function remove($key){
        if($this->get($key)) return $this->connection->del($this->keyprefix . $key);
    }
    
    // 查看
    public function get($key){
        return $this->connection->get($this->keyprefix . $key);
    }
    
    // 实例化类
    public static function getInstance($conf){
        if(self::$class === null){
            self::$class = new Redis($conf);
        }
        return self::$class;
    }
    
}

$conf = array(
    'host'     => '127.0.0.1',
    'port'     => 6379,
    'database' => 15
);

$redis = Redis::getInstance($conf);
$redis->set('a', 'b');
echo $redis->get('a');
?>