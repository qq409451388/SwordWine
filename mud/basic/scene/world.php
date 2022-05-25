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
        $sceneConfig = Config::get("scene");
        $this->putScene(new Scene("光明顶", 8, 8), 0, 6);
        $this->putScene(new Scene("天山", 8, 8), 2, 7);
        $this->putScene(new Scene("少林", 8, 8), 10, 6);
        $this->putScene(new Scene("武当", 8, 8), 8, 4);
        $this->putScene(new Scene("峨眉", 8, 8), 5, 2);
        $this->putScene(new Scene("五毒", 8, 8), 7, 1);
        return $this;
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