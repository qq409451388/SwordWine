<?php

/**
 * LeetCode 965 单值二叉树
 * 如果二叉树每个节点都具有相同的值，那么该二叉树就是单值二叉树。
 * 只有给定的树是单值二叉树时，才返回 true；否则返回 false。
 *
 * Definition for a binary tree node.
 * class TreeNode {
 *     public $val = null;
 *     public $left = null;
 *     public $right = null;
 *     function __construct($val = 0, $left = null, $right = null) {
 *         $this->val = $val;
 *         $this->left = $left;
 *         $this->right = $right;
 *     }
 * }
 */
class Solution965 {

    /**
     * @param TreeNode $root
     * @return Boolean
     */
    function isUnivalTree($root) {
        $map = [];
        $this->calc($root, $map);
        return count(array_keys($map)) == 1;
    }

    function calc($root, &$array){
        if(null == $root){
            return;
        }
        if(1 < count($array)){
            return;
        }
        if(!is_null($root->val)){
            $array[$root->val] = 1;
        }

        $this->calc($root->left, $array);
        $this->calc($root->right, $array);
    }
}

Class TreeNode
{
    public $val;
    public $left;
    public $right;

    public function __construct($val, $left = null, $right = null){
        $this->val = $val;
        $this->left = $left;
        $this->right = $right;
    }
}
$node21 = new TreeNode(1);
$node22 = new TreeNode(1);
$node23 = new TreeNode(null);
$node24 = new TreeNode(1);
$node12 = new TreeNode(1, $node23, $node24);
$node11 = new TreeNode(1, $node21, $node22);
$root = new TreeNode(1, $node11, $node12);
$res = (new Solution())->isUnivalTree($root);
var_dump($res);