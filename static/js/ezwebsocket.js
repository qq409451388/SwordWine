class EzWebSocket {
    constructor(uri) {
        this.ws = new WebSocket(uri);
    }
    init(userName, func){
        this.ws.addEventListener('open', function (event) {

        });
        var _this = this;
        this.ws.addEventListener('message', function (event) {
            console.log('Message from server ', event.data);
            var obj = JSON.parse(event.data);
            //登录校验
            if (obj.dataType === 4) {
                var m = {
                    "key": obj.key,
                    'dataType': 4,
                    "userName": userName
                };
                _this.ws.send(JSON.stringify(m));
            } else {
                func(obj);
            }
        });
    }

    send(userName, message) {
        this.ws.send(JSON.stringify({"dataType": 1, "userName": userName, "message": message}));
    }

    sendAll(message) {
        this.ws.send(JSON.stringify({"dataType": 2, "message": message}));
    }
}