<?php

/**
 * SwordWine场景服务器
 */
class SwSceneServer
{
    private $server;
    private $world;

    //上线
    private const ONLINE = 4;
    //下线
    private const OFFLINE = 5;

    public function __construct($ip, $port){
        $this->server = EzWebSocketServer::get($ip, $port)->init();
        $this->world = World::getInstance()->init();
    }

    public function start(){
        Logger::console("[SwSceneServer] Start Successed!");
        Logger::console("[SwSceneServer] ServerInfo:ws://".$this->server->getIp().":".$this->server->getPort());
        $this->server->start(function($socket, $msg){
            $msgData = EzCollection::decodeJson($msg);
            if(is_null($msgData)){
                return;
            }
            var_dump($msgData);
            $this->server->sendToUser($socket, EzString::encodeJson(["html"=>$this->world->showHtml()]));
        }, function($socket, $key){
            $data = [
                'key' => $key,
                "dataType" => self::ONLINE
            ];
            $data = EzString::encodeJson($data);
            $this->server->sendToUser($socket, $data);
        }, function($startSucc, $except){
        });
    }
}