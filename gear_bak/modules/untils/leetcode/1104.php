<?php


/**
 * 在一棵无限的二叉树上，每个节点都有两个子节点，树中的节点 逐行 依次按“之” 字形进行标记。
 * 如下图所示，在奇数行（即，第一行、第三行、第五行……）中，按从左到右的顺序进行标记；
 * 而偶数行（即，第二行、第四行、第六行……）中，按从右到左的顺序进行标记。
 * 给你树上某一个节点的标号 label，请你返回从根节点到该标号为 label 节点的路径，该路径是由途经的节点标号所组成的。
 */
class Solution1104
{

    /**
     * @param Integer $label
     * @return Integer[]
     */
    function pathInZigZagTree($label)
    {
        //深度
        $deep = 0;
        //计算节点在第几层，第几个，结果送入m，n
        $target = 0;
        while (true) {
            if ($label <= $target) {
                break;
            }
            $target += pow(2, $deep);
            $deep++;
        }
        if ($deep % 2 == 0) {
            $pos = $target - $label + 1;
        } else {
            $pos = $label - $this->add($deep - 1);
        }
        $res = [];
        for ($i = $deep; $i > 0; $i--) {
            $calc = $this->calc($pos, $i);
            $res[$i - 1] = $calc[1];
            $pos = $calc[0];
        }
        sort($res);
        return $res;
    }

    function calc($pos, $deep)
    {
        var_dump($pos, $deep);
        $p = $pos % 2;
        if ($p == 0) {
            $np = ($pos - $p) / 2;
        } else {
            $np = ($pos - $p) / 2 + 1;
        }
        //奇数行 左至右 偶数行 右至左
        if ($deep % 2 == 0) {
            return [$np, $this->add($deep) - $pos + 1];
        } else {
            return [$np, $this->add($deep - 1) + $pos];
        }
    }

    function add($deep)
    {
        $res = 0;
        for ($i = 0; $i < $deep; $i++) {
            $res += pow(2, $i);
        }
        return $res;
    }
}

$res = (new Solution())->pathInZigZagTree(1);
var_dump($res);