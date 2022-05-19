<?php
class UserSvc
{
    /**
     * 系统保留，注册时禁止
     */
    public const UNKNOW_NAME = "未知";

    private const USER_ONLINE_KEY = "USER_ONLINE_KEY";
    private const USER_ONLINE_SOCKETKEY = "USER_ONLINE_SOCKETKEY";
    public function setUserKey($userName, $key){
        return CacheFactory::getInstance()->set(self::USER_ONLINE_SOCKETKEY.$key, $userName)
            && CacheFactory::getInstance()->set(self::USER_ONLINE_KEY.$userName, $key);
    }

    public function getSocketKeyByUserName($userName){
        return CacheFactory::getInstance()->get(self::USER_ONLINE_KEY.$userName);
    }

    public function getUserNameBySocketKey($key){
        return CacheFactory::getInstance()->get(self::USER_ONLINE_SOCKETKEY.$key)??self::UNKNOW_NAME;
    }

    /**
     * 好友 或者 对方关闭陌生人免打扰
     * @param $from
     * @param $target
     * @return bool
     */
    public function checkChatAuth($from, $target){
        if(self::UNKNOW_NAME == $from || self::UNKNOW_NAME == $target){
            return false;
        }
        return true;
    }

    public function login($userName, $passWord){
        return "xxxx";
    }
}