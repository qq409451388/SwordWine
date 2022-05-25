<?php
/**
 * 世界服务器启动器
 */
const MUD_PATH = __DIR__."/../";
const CORE_PATH = MUD_PATH . "/gear";
const CUSTOM_PATH = [
    MUD_PATH . "/mud"
];
//static path
const STATIC_PATH = MUD_PATH . "/static";
const LOCAL_HOST = "127.0.0.1";
include(dirname(__FILE__, 2) . "/autoload.php");

ini_set("memory_limit", "4096M");
ini_set("date.timezone", "Asia/Shanghai");
$con = new SwSceneServer($argv[1]??LOCAL_HOST, $argv[2]??8111);
$con->start();