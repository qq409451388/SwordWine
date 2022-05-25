<?php

/**
 * SwordWine聊天服务器
 */
class SwChatServer
{
    private $userSvc;
    private $server;
    /**
     * @var array userKey => socket
     */
    private $userKeyHash = [];

    //私聊
    private const PRIVATE_MESSAEG = 1;
    //世界发言
    private const WORLD_MESSAEG = 2;
    //广播
    private const BROAD_CAST = 3;
    //上线
    private const ONLINE = 4;
    //下线
    private const OFFLINE = 5;

    public function __construct($ip, $port){
        $this->server = EzWebSocketServer::get($ip, $port)->init();
        $this->userSvc = new UserSvc();
    }

    public function start(){
        Logger::console("[SwChatServer] Start Successed!");
        Logger::console("[SwChatServer] ServerInfo:ws://".$this->server->getIp().":".$this->server->getPort());
        $this->server->start(function($socket, $msg){
            $msgData = EzCollection::decodeJson($msg);
            if(is_null($msgData)){
                return;
            }
            DBC::assertTrue($this->msgCheck($msgData), "[SwChatServer] MsgData is Wrong!");
            $msgType = $msgData['dataType'];
            $msgContent = $msgData;
            switch ($msgType) {
                case self::PRIVATE_MESSAEG:
                    $this->privateChat($socket, $msgContent);
                    break;
                case self::WORLD_MESSAEG:
                    $this->worldChat($socket, $msgContent);
                    break;
                case self::BROAD_CAST:
                    $this->broadcast($socket, $msgContent);
                    break;
                case self::ONLINE:
                    $this->online($socket, $msgContent);
                    break;
                case self::OFFLINE:
                    $this->offline($socket, $msgContent);
                    break;
                default:
                    break;
            }
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

    private function msgCheck($msg){
        if(!is_array($msg)){
            return false;
        }
        if(!isset($msg['dataType'])){
            return false;
        }
        if(!is_numeric($msg['dataType'])){
            return false;
        }
        return true;
    }

    private function getUserSocket($userKey){
        return $this->userKeyHash[$userKey]??null;
    }

    /**
     * 私聊
     * @param $socket
     * @param $msgData
     */
    private function privateChat($socket, $msgData){
        $key = $this->getKeyByUserName($msgData['userName']);
        $this->checkAuth($socket, $key, $msgData['userName']);
        $receiver = $this->getUserSocket($key);
        if(!is_resource($receiver)){
            return;
        }
        $message = $msgData['message'];
        $this->server->sendToUser($receiver, EzString::encodeJson(["message"=>$message, "senderUserName"=>$msgData['userName']]));
    }

    /**
     * 世界广播，由用户发起的，全局发言，所以需要限制频率
     * 自己也能看到消息
     * @param $socket
     * @param $message
     */
    private function worldChat($socket, $message){
        //todo socket验证权限、速率控制
        $key = $this->server->getSocketKeyBySocket($socket);
        $userName = $this->userSvc->getUserNameBySocketKey($key);
        $message["senderUserName"] = $userName;
        $message["timestamp"] = EzDate::now()->toString();
        $message = EzString::encodeJson($message);
        $this->server->sendToAllUsers($message);
    }

    /**
     * 系统性的，所以只有GM有权限
     * 发起者不能看到消息
     * @param $socket
     * @param $message
     */
    private function broadcast($socket, $message){
        //todo socket验证权限、速率控制
        $message = EzString::encodeJson($message);
        $this->server->sendToAllUsers($message, [$socket]);
    }

    private function online($socket, $messageArr){
        $key = $messageArr['key']??'';
        if(empty($key)){
            Logger::error("[SwChatServer] OnlineFail! key is not exists！");
            return;
        }
        if(isset($this->userKeyHash[$key]) && $socket != $this->userKeyHash[$key]){
            Logger::error("[SwChatServer] Online Fail! userName:{}", $messageArr['userName']??"null");
            return;
        }
        $this->userSvc->setUserKey($messageArr['userName'], $key);
        $this->userKeyHash[$key] = $socket;
    }

    private function offline($socket, $messageArr){
        $key = $messageArr['key'];
        if(empty($key)){
            return;
        }
        unset($this->userKeyHash[$key]);
    }

    private function getKeyByUserName($userName){
        return $this->userSvc->getSocketKeyByUserName($userName);
    }

    /**
     * 好友 或者 对方关闭陌生人免打扰
     * @param $socket
     * @param $key
     * @param $userName
     */
    private function checkAuth($socket, $key, $targetUserName){
        $socketKey = $this->server->getSocketKeyBySocket($socket);
        $fromUserName = $this->userSvc->getUserNameBySocketKey($socketKey);
        $targetUserName = $targetUserName??UserSvc::UNKNOW_NAME;
        DBC::assertTrue($this->userSvc->checkChatAuth($fromUserName, $targetUserName), "[SwChatServer] No Auth For This User userName：$targetUserName");
    }
}