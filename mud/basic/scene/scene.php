<?php

/**
 * 场景
 * 作用：1、承载玩家、NPC等
 *      2、控制玩家技能权限（野外，帮会范围，摆摊）
 */
class Scene extends AbstractScene
{
    /**
     * @var array 玩家列表
     */
    private $playerList;

    /**
     * @var array npc列表
     */
    private $npcList;

    /**
     * @var string 场景开放权限
     */
    private $permission;

    public function isValid(){
        // TODO: Implement isValid() method.
        return true;
    }

    public function showHtml(){
        return $this->getSimpleHtmlTable();
    }
}