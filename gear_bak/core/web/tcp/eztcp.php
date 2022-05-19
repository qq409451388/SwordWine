<?php
class EzTCP extends BaseTcpClient
{
    public function init():BaseTcpClient{
        $this->conn = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
        socket_connect($this->conn, $this->getIp(), $this->getPort());
        $isSucc = socket_last_error($this->conn);
        if(0 != $isSucc){
            $err = socket_strerror($isSucc);
            DBC::throwEx("[EzTCP]Init Fail! ".$err);
        }
        return $this;
    }

    public function send($msg){
        socket_write($this->conn, $msg, strlen($msg));
        return socket_read($this->conn, 8190);
    }

    protected function destory(){
        if(null != $this->conn){
            socket_close($this->conn);
        }
    }
}