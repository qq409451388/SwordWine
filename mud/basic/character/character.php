<?php
abstract class Character
{
    /**
     * @var BasicAttribute 基础属性
     */
    protected $basicAttrbute;

    /**
     * @var array[] IMartial 功法（技能）
     */
    protected $martials;

    /**
     * @var int 功力
     */
    protected $power;

    /**
     * @var int 人物等级
     */
    protected $level;
}