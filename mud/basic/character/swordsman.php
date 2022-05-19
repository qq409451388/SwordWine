<?php

/**
 * 玩家人物
 */
class SwordsMan extends Character
{
    /**
     * @var array[] BodyBase 身体部位
     */
    private $bodies;

    /**
     * @var int 经验值
     */
    private $exp;

    /**
     * 初始化人物对象，将依赖数据传入
     */
    public function init(BasicAttribute $basicAttribute){
        $this->basicAttrbute = $basicAttribute;
    }

    public function load($bodies, $martials){
        $this->bodies = $bodies;
        $this->martials = $martials;
    }

    /**
     * *****开放接口start*****
     */

    /**
     * @return void 普通攻击
     */
    public function attack(SwordsMan $enemy){

    }

    /**
     * 增加经验
     */
    public function addExp(int $exp){
        $this->exp+=$exp;
        $nextLevelExpStart = CharacterConst::getExp($this->level+1);
        if($this->exp >= $nextLevelExpStart){
            $this->upgrade();
        }
    }

    public function skillList(){
        return $this->martials;
    }

    /**
     * 施放技能-单体
     * @return void
     */
    public function dischargeSkill(SwordsMan $enemy){

    }

    /**
     * 施放技能-群体
     * @return void
     */
    public function dischargeSkillAll(array $enemy){

    }

    /**
     * *****开放接口End*****
     */

    /**
     * @return void 升级
     */
    private function upgrade(){
        $this->level++;
    }
}