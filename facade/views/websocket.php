<html>
    <head>
        <title>聊天频道</title>
    </head>
    <script src="<?php echo Env::getDomain().'/js/jquery.min.js'?>"></script>
    <script src="<?php echo Env::getDomain().'/js/utils.js'?>"></script>
    <script src="<?php echo Env::getDomain().'/js/ezwebsocket.js'?>"></script>
    <style>
        #main {width:800px;min-height:400px;max-height:500px;border:1px solid red;}
        #main .sub{float:left;width:100px;height:30px;border:1px solid skyblue;}
        #main #sub{display: block;}
        #main .container{display: none; border:1px solid red;width:800px;height:400px;margin-top:20px;}
        .clear_both {clear:both}
        .show {display: block;}
        .hide {display: none;}
    </style>
</html>
<body>
    <div id="main">
        <input type="hidden" id="curContainerName">
        <div id="sub">
            <div class="sub" data="containerWorld">世界</div>
            <div class="sub" data="containerPrivate">私聊</div>
        </div>
        <div class="clear_both"></div>
        <div class="container" id="containerWorld">

        </div>
        <div class="container" id="containerPrivate">

        </div>
    </div>
    <div id="inputArea" class="hide">
        <label for="sendAll">请输入：
            <textarea name="" id="sendAll" cols="30" rows="10"></textarea>
            <button onclick="sendMsgToAll()">发送</button>
        </label><br>
        <!--<label for="sendUser">请输入：
            <textarea name="" id="sendUser" cols="30" rows="10"></textarea>
            <button onclick="sendMsgToAll()">发送</button>
        </label><br>-->
    </div>
    <div id="loginArea" class="show">
        <label for="userName">用户名：<input type="text" id="userName" name="userName"></label><br>
        <label for="passWord">密码：<input type="password" id="passWord"></label>
        <button onclick="login()">登录</button>
    </div>
</body>
<script>
    var ws = null;
    function login(){
        let userName = $("#userName").val();
        let passWord = $("#passWord").val();
        let loginAuthUrl = "<?php echo Env::getDomain()."/chat/login";?>";
        let params = {"userName":userName, "passWord":passWord};
        get(loginAuthUrl, params, function(result){
            console.log(result);
            if(result.errCode === 0){
                setCookie("userName", result.data.userName);
                setCookie("authKey", result.data.authKey);
                ws = new EzWebSocket("<?php echo $chatServer;?>");
                ws.init(userName, onMessageIn);
                $("#inputArea").show();
                $("#loginArea").hide();
            } else {
                alert(result.msg);
            }
        }, function(){});
    }

    function onMessageIn(message){
        console.log(JSON.stringify(message));
        var ele = "<div>【"+message.senderUserName+"】:"+message.message+"——时间："+message.timestamp+"</div>";
        if(2 === message.dataType){
            $("#containerWorld").append(ele);
        }
        if(1 === message.dataType){
            $("#containerPrivate").append(ele);
        }
    }

    function sendMsgToUser(targetUserName, msg){
        ws.send(targetUserName, msg);
    }

    function sendMsgToAll(){
        var msg = $("#sendAll").val();
        ws.sendAll(msg);
        $("#sendAll").val("");
    }

    $(document).ready(function(){
        $(".sub").eq(0).click();
    });

    $(".sub").on("click", function(){
        $(".sub").each(function(){
            $(this).css("background-color", "white");
        });
        $(".container").each(function(){
            $(this).hide();
        });
        $(this).css("background-color", "red");
        var containerName = $(this).attr("data");
        $("#"+containerName).show();
        $("#curContainerName").val(containerName);
    });
</script>