<?php
class Chat extends BaseController
{
    public function websocket($request){
        return $this->show([
            "chatServer"=>"ws://192.168.0.109:8100"
        ], "websocket");
    }

    public function login(Request $request){
        $userName = $request->get("userName");
        $passWord = $request->get("passWord");
        if($request->isEmpty() || empty($userName) || empty($passWord)){
            return EzRpcResponse::error(CommonCode::CODE_LOGIN_FAIL, "登录失败")->toJson();
        }
        $authKey = "213";//$this->userSvc->login($userName, $passWord);
        if(empty($authKey)){
            return EzRpcResponse::error(CommonCode::CODE_LOGIN_FAIL, "登录失败")->toJson();
        }else{
            return EzRpcResponse::OK(["authKey"=>$authKey, "userName"=>$userName], "登录成功")->toJson();
        }
    }

}