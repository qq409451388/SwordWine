<html>
<script src="<?php echo Env::getDomain().'/js/jquery.min.js'?>"></script>
<script src="<?php echo Env::getDomain().'/js/utils.js'?>"></script>
<script src="<?php echo Env::getDomain().'/js/ezwebsocket.js'?>"></script>
<div id="main"></div>
</html>
<script>
    ws = new EzWebSocket("<?php echo $chatServer;?>");
    ws.init("test", onMessageIn);

    setTimeout(function(){
        ws.sendToUser("test","asd");
    }, 1000)
    function onMessageIn(message){
        console.log(JSON.stringify(message));
        $("#main").html(message.html);
    }
</script>