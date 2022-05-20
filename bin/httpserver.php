<?php
/**
 * 游戏网页端启动器
 */
const MUD_PATH = __DIR__."/../";
const CORE_PATH = MUD_PATH . "/gear";
//http server path
const USER_PATH = MUD_PATH . "/facade";
//static path
const STATIC_PATH = MUD_PATH."/static";
const LOCAL_HOST = "127.0.0.1";
const TEMPLATE_DIR = USER_PATH."/views";
const ENV = "dev";
include(dirname(__FILE__, 2) . "/autoload.php");

ini_set("memory_limit", "1024m");
ini_set("date.timezone", "Asia/Shanghai");
$http = new Http((new Gear())->init($userClasses));
$http->init($argv[1]??LOCAL_HOST, $argv[2]??8101, STATIC_PATH)->start();