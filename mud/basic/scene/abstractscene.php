<?php

/**
 * 场景抽象类
 */
abstract class AbstractScene
{
    private const LEVEL_1 = 1;
    /**
     * @var int 当前场景地图层级 以1为最高-World
     */
    private $level;

    private $name;

    /**
     * @var array 当前场景所有子场景数组
     * @example $positions[2][5] = $scene; 为横坐标x， 纵坐标y存在场景
     * [0,2] [1,2] [2,2]
     * [0,1] [1,1] [2,1]
     * [0,0] [1,0] [2,0]
     */
    private $positions;

    /**
     * @var int 当前场景所在父场景中的位置X
     */
    private $locateX;

    /**
     * @var int 当前场景所在父场景中的位置Y
     */
    private $locateY;

    /**
     * @var int 当前场景最大范围X
     */
    private $regionX;

    /**
     * @var int 当前场景最大范围Y
     */
    private $regionY;

    public function __construct($name, $regionX, $regionY,
                                $level = self::LEVEL_1,
                                $locateX = null, $locateY = null){
        $this->level = $level;
        $this->regionX = $regionX;
        $this->regionY = $regionY;
        $this->name = $name;
        $this->locateX = $locateX;
        $this->locateY = $locateY;
    }

    /**
     * @return string 以html展示场景
     */
    public abstract function showHtml();

    public function hasScene($x, $y){
        return isset($this->positions[$x]) && isset($this->positions[$x][$y]);
    }

    public function getScene($x, $y){
        if(!$this->hasScene($x, $y)){
            return null;
        }
        return $this->positions[$x][$y];
    }

    /**
     * @return string 场景名称
     */
    public function getName() {
        return $this->name;
    }

    public function getLocateX(){
        return $this->locateX;
    }

    public function getLocateY(){
        return $this->locateY;
    }

    public function getRegionX(){
        return $this->regionX;
    }

    public function getRegionY(){
        return $this->regionY;
    }

    public function getLevel(){
        return $this->level;
    }

    /**
     * @return AbstractScene 获取最近的北方的场景
     */
    public function getNorthScene($scene){
        if(!$scene instanceof AbstractScene){
            return null;
        }
        $north = null;
        for($i = $scene->getLocateY();$i<=$this->getRegionY();$i++){
            if($this->hasScene($scene->getLocateX(), $i)){
                $north = $this->getScene($scene->getLocateX(), $i);
            }
        }
        return $north;
    }

    /**
     * @return AbstractScene 获取最近的南方的场景
     */
    public function getSouthScene($scene){
        if(!$scene instanceof AbstractScene){
            return null;
        }
        $south = null;
        for($i = $scene->getLocateY();$i>=0;$i--){
            if($this->hasScene($scene->getLocateX(), $i)){
                $south = $this->getScene($scene->getLocateX(), $i);
            }
        }
        return $south;
    }

    /**
     * @return AbstractScene 获取最近的东方的场景
     */
    public function getEastScene($scene){
        if(!$scene instanceof AbstractScene){
            return null;
        }
        $east = null;
        for($i = $scene->getLocateX();$i<=$this->getRegionX();$i++){
            if($this->hasScene($i, $scene->getLocateY())){
                $east = $this->getScene($i, $scene->getLocateY());
            }
        }
        return $east;
    }

    /**
     * @return AbstractScene 获取最近的西方的场景
     */
    public function getWestScene($scene){
        if(!$scene instanceof AbstractScene){
            return null;
        }
        $west = null;
        for($i = $scene->getLocateX();$i>=0;$i--){
            if($this->hasScene($i, $scene->getLocateY())){
                $west = $this->getScene($i, $scene->getLocateY());
            }
        }
        return $west;
    }

    protected abstract function isValid();

    public function putScene($scene, $x, $y){
        DBC::assertTrue(!$this->hasScene($x, $y), "[Scene] locate{$x},{$y} already has a scene!");
        DBC::assertTrue($scene instanceof AbstractScene, "[Scene] ".get_class($scene)." Must Instance of AbstractScene!");
        DBC::assertTrue($scene->isValid(), "[Scene] Scene Is Not Valid!");
        $this->positions[$x][$y] = $scene;
    }

    /**
     * @return bool 是否是顶层场景
     */
    public function isTop(){
        return $this instanceof World && self::LEVEL_1 == $this->getLevel();
    }

    /**
     * @return string 简单将区域以表格的形式打印出来，只显示名称
     */
    protected function getSimpleHtmlTable(){
        $html = "<table width='100%' height='75%' border='1' cellpadding='0' cellspacing='0'>";
        for($i=$this->getRegionY();$i>=0;$i--){
            $html .= "<tr>";
            for($j=0;$j<=$this->getRegionX();$j++){
                $pos = "({$j},{$i})";
                $display = "width:100px;height:30px;";
                if($this->hasScene($j, $i)){
                    $name = $this->getScene($j, $i)->getName()."<br/>".$pos;
                    $display .= "background:skyblue;";
                }else{
                    $name = $pos;
                }
                $html .= "<td style='".$display."'>".$name."</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        return $html;
    }
}