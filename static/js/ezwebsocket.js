class EzWebSocket {
    constructor(uri) {
        this.ws = new WebSocket(uri);
        this.isReady = false;
        this.key = "";
    }

    //需要预先进行登录校验，将用户信息与socket绑定
    init(userName, func){
        this.ws.addEventListener('open', function (event) {

        });
        var _this = this;
        this.ws.addEventListener('message', function (event) {
            console.log('Message from server ', event.data);
            var obj = JSON.parse(event.data);
            //登录校验
            if (obj.dataType === "BIND_USER_KEY") {
                _this.key = obj.key;
                var m = {
                    "key": obj.key,
                    'toMaster': true,
                    'systemFunc':"bindUserNameOk",
                    "userName": userName
                };
                setCookie("userName", userName);
                _this.ws.send(JSON.stringify(m));
            } else if (obj.dataType === "BIND_USER_KEY_OK") {
                _this.isReady = true;
            } else if (obj.dataType === "CHECK_ACTIVE") {
                var c = {
                    "key": _this.key,
                    'toMaster': true,
                    'systemFunc':"checkClientActiveOk",
                    "userName": userName
                };
                _this.ws.send(JSON.stringify(c));
            } else {
                func(obj);
            }
        });
    }

    sendA(message){
        if(!this.isReady){
            console.log("WebSocket Is Connecting!");
            return false;
        }
        this.ws.send(JSON.stringify({"dataType": 1, "message": message}));
    }

    sendToUser(userName, message) {
        if(!this.isReady){
            console.log("WebSocket Is Connecting!");
            return false;
        }
        this.ws.send(JSON.stringify({"dataType": 1, "userName": userName, "message": message}));
    }

    sendAll(message) {
        if(!this.isReady){
            console.log("WebSocket Is Connecting!");
            return false;
        }
        this.ws.send(JSON.stringify({"dataType": 2, "message": message}));
    }
}