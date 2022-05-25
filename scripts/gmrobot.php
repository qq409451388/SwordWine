<?php
const CORE_PATH = MUD_PATH . "/gear";
const ENV = "dev";
include(dirname(__FILE__, 2) . "/autoload.php");
EzWebSocketServer::get(Env::getIp(), 8111)->sendToUser($userName, $data);