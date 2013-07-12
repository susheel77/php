<?php
/**
 * @description redis
 * @author zhanglei <zhanglei19881228@sina.com>
 */




class Redis{
    
    private static $class = null;       // 实例化对象
    private $connection;                // redis连接对象
    private $keyprefix = 'redis_';      // 存储key前缀
    
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
        if(!$conf || !is_array($conf) || !isset($conf['host']) || !isset($conf['port'])) return false;
    }
    
    // 设置key value值, 0 无过期
    public function set($key, $value, $expire = 0){
        return $this->connection->setex($this->keyprefix . $key, $expire, $value);
    }
    
    // 修改key值
    public function update($key, $value, $expire = 0){
        if($this->connection->get($this->keyprefix . $key)) return $this->connection->setex($this->keyprefix . $key, $value, $expire);
    }
    
    // 删除key
    public function remove($key){
        if($this->connection->get($this->keyprefix . $key)) return $this->connection->del($this->keyprefix . $key);
    }

    // 清空队列
    public function truncate($key){
        return $this->connection->del($this->keyprefix . $key);
    }
    
    // 得到key
    public function get($key){
        return $this->connection->get($this->keyprefix . $key);
    }

    // 队列, 向首部增加数据
    public function lpush($key, $value){
        return $this->connection->lpush($this->keyprefix . $key, $value);
    }

    // 队列, 向尾部增加数据
    public function rpush($key, $value){
        return $this->connection->rpush($this->keyprefix . $key, $value);
    }

    // 队列, 从首部弹出数据，并且删除此数据
    public function lpop($key){
        return $this->connection->lpop($this->keyprefix . $key);
    }

    // 队列, 从尾部弹出数据, 并且删除数据
    public function rpop($key){
        return $this->connection->rpop($this->keyprefix . $key);
    }

    // 查看队列中的总数
    public function llen($key){
        return $this->connection->llen($this->keyprefix . $key);
    }

    // 查看队列中的数据, 有偏移量
    public function lrange($key, $start, $offset){
        return $this->connection->lrange($this->keyprefix . $key, $start, $offset);
    }

    // 查看队列中某一个值
    public function lindex($key, $index){
        return $this->connection->lindex($this->keyprefix . $key, $index);
    }

    // 实例化类
    public static function getInstance($conf){
        if(self::$class === null){
            self::$class = new Redis($conf);
        }
        return self::$class;
    }
    
}

?>
