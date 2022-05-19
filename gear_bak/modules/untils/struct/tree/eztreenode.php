<?php

/**
 * 树-节点
 */
class EzTreeNode
{
    private $data;
    private $left;
    private $right;

    public function __construct($data, $left = null, $right = null){
        $this->data = $data;
        $this->left = $left;
        $this->right = $right;
    }

    public function getData() {
        return $this->data;
    }

    public function getLeft() {
        return $this->left;
    }

    public function getRight() {
        return $this->right;
    }

    public function dump(){
        echo $this->getData().PHP_EOL;
    }
}