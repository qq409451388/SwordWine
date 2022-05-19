<?php
/**
 * LeetCode 967 连续差相同的数字
 * 返回所有长度为 n 且满足其每两个连续位上的数字之间的差的绝对值为 k 的 非负整数 。
 * 请注意，除了 数字 0 本身之外，答案中的每个数字都 不能 有前导零。例如，01 有一个前导零，所以是无效的；但 0是有效的。
 * 你可以按 任何顺序 返回答案。
 */
class Solution967 {

    /**
     * @param Integer $n
     * @param Integer $k
     * @return Integer[]
     */
    function numsSameConsecDiff($n, $k) {
        $res = [];
        for($i=1;$i<10;$i++){
            $this->calc($i, $n, $k, $res);
        }
        return $res;
    }

    function recursion($tmpArr, $k){
        $e = end($tmpArr);
        $array = [];
        if($k  == 0){
            $tmp = $tmpArr;
            $tmp[] = $e;
            $array[] = $tmp;
        }else{
            if($e+$k <= 9){
                $tmp = $tmpArr;
                $tmp[] = $e+$k;
                $array[] = $tmp;
            }
            if($e-$k >= 0){
                $tmp = $tmpArr;
                $tmp[] = $e-$k;
                $array[] = $tmp;
            }
        }
        return $array;
    }

    function calc($i, $n, $k, &$res){
        $num[] = $i;
        $array = [$num];
        $flag = false;
        //按从左至右生成数字
        for($s=1;$s<$n;$s++){
            $e = end($num);
            /**
             * 遍历上一层循环计算出的正确的数据集合，向下继续探寻正确的数值
             */
            $newArr = [];
            foreach($array as $arr){
                $newArr = array_merge($newArr, $this->recursion($arr, $k));
            }
            $array = $newArr;
        }
        if(empty($array)){
            return;
        }
        foreach($array as $num){
            $res[] = implode("", $num);
        }
    }
}
$res = (new Solution967())->numsSameConsecDiff(3, 1);
var_dump($res);