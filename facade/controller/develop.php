<?php
class Develop extends BaseController
{
    public function map(){
        return $this->show([
            "chatServer"=>"ws://".Env::getIp().":8111"
        ], "tabletest");
    }
}