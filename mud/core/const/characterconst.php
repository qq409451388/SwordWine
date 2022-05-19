<?php
class CharacterConst
{
    public static $arr = [1, 2, 3];
    /**
     * @param $exp
     * @return void 通过经验数值确认人物等级
     */
    public static function getLevelByExp($exp){

    }

    public static function getExp($level){
        return self::fibonacci($level)*10;
    }

    /**
     * algorithm: input An then return A(n-1)+A(n-2)
     * input 1 then return 1
     * input 2 then return 2
     * input 3 then return 3
     * input 4 then return 5
     * input 5 then return 8……
     * @param int $int 1,2……
     * @return int exp
     */
    private static function fibonacci(int $int){
        if(!isset(self::$arr[$int-1])){
            $res = self::fibonacci($int-1) + self::fibonacci($int-2);
            self::$arr[$int-1] = $res;
        }
        return self::$arr[$int-1];
    }
}