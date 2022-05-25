<?php
class Test extends BaseController
{
    public function table(){
        return $this->show([
            "chatServer"=>"ws://".Env::getIp().":8111"
        ], "tabletest");
    }
}