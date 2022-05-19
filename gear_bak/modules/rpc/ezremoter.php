<?php
class EzRemoter
{
    private $curl;
    public static function getInstance($remoteName){
        return new EzRemoter($remoteName);
    }

    private function __construct($name){
        $this->remoteName = $name;
        $this->curl = new EzCurl();
    }

    public function get($url, $params){
        $this->curl->setUrl($url);
        return $this->curl->get($params);
    }

    public function __call($funcName, $args){
        var_dump($this, $funcName, $args);
    }
}