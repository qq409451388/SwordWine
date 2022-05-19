<?php
class Index extends BaseController
{
    /**
     * @RequestMapping('/ques')
     * @param $request
     * @return EzRpcResponse
     */
    public function getQuestions($request){
        $data = DB::get("mytest")->queryOne("select * from categorys where text like :like", [":like"=>"%".$request->get("n")."%"]);
        $sql = "select * from questions2 where datapid = :dataPId";
        $binds = [
            ":dataPId" => $data['dataid'],
        ];
        $result = DB::get("mytest")->query($sql, $binds);
        return EzRpcResponse::OK($result);
    }
}