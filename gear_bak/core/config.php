<?php
class Config
{
    private static $config;
    public static function get($key){
        if(empty($key)){
            return;
        }
        $try = self::$config[$key]??null;
        if(is_null($try)){
            $pj = CORE_PATH.'/config/'.$key.'.json';
            $content = @file_get_contents($pj);
            if(false !== $content){
                self::set([$key=>EzCollection::decodeJson($content)]);
            }
        }
        return self::$config[$key]??null;
    }

    public static function getAll($p){
        $pj = CORE_PATH.'/config/'.$p.'.json';
        $content = @file_get_contents($pj);
        if(false !== $content){
            self::set([$p=>EzCollection::decodeJson($content)]);
        }
        return self::get($p);
    }

    public static function set($arr){
        foreach($arr as $k => $v){
            self::$config[$k] = $v;
        }
    }
}
