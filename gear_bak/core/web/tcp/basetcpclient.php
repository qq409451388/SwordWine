<?php
abstract class BaseTcpClient
{
    //初始化资源
    protected $conn;

    //资源管理器
    protected static $instance;

    private $ip;
    private $port;

    public static function get($ip, $port){
        $key = $ip.$port;
        if(!isset(self::$instance[$key])){
            self::$instance[$key] = new static();
            self::$instance[$key]->ip = $ip;
            self::$instance[$key]->port = $port;
        }
        return self::$instance[$key] ?? null;
    }

    protected abstract function destory();

    public function __destruct(){
        $this->destory();
    }

    public function getIp(){
        return $this->ip;
    }

    public function getPort(){
        return $this->port;
    }

    public abstract function send(string $msg);
}