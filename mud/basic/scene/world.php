<?php

/**
 * 世界
 * 作用： 1、承载场景
 *       2、记录场景关系
 */
class World extends AbstractScene
{
    private static $ins;

    //单例
    public static function getInstance(){
        if(null == self::$ins){
            self::$ins = new self("剑与酒 世界", 12, 10);
        }
        return self::$ins;
    }

    public function init(){
        $sceneConfig = Config::get("scene", MUD_PATH);
        self::putScenes($sceneConfig, $this);
        return $this;
    }

    /**
     * 递归加载场景配置
     * @param $sceneConfig
     * @param $targetScene
     */
    private static function putScenes($sceneConfig, $targetScene){
        foreach($sceneConfig as $config){
            $scene = new Scene($config['name'], $config['regionX'], $config['regionY'],
                $config['level'], $config['locateX'], $config['locateY']);
            DBC::assertTrue($scene->isValid(), "[World Exception] Init SceneList Fail! Data:".EzString::encodeJson($scene));
            World::putScenes($config['nextLevelConfig']??[], $scene);
            $targetScene->putScene($scene, $scene->getLocateX(), $scene->getLocateY());
        }
    }

    /**
     * @return string 世界地图 html
     */
    public function showHtml(){
        return $this->getSimpleHtmlTable();
    }

    public function isValid(){
        // TODO: Implement isValid() method.
        return true;
    }
}