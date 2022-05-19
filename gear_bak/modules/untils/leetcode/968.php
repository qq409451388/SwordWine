<?php
/**
 * LeetCode 968 监控二叉树
 * 给定一个二叉树，我们在树的节点上安装摄像头。
 * 节点上的每个摄影头都可以监视其父对象、自身及其直接子对象。
 * 计算监控树的所有节点所需的最小摄像头数量。
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
class Solution968 {

    private $total;

    /**
     * @param TreeNode $root
     * @return Integer
     */
    function minCameraCover($root) {
        $res = $this->deal($root);
        if($res == 2){
            $this->total++;
        }
        return $this->total;
    }

    function deal($node){
        if(null == $node){
            return -1;
        }

        $l = $this->deal($node->left);
        $r = $this->deal($node->right);
        if(2 == $l || 2 == $r){
            $this->total++;
            return 3;
        }
        if(3 == $l || 3 == $r){
            return -1;
        }
        return 2;
    }
}