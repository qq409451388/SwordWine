<?php
const BASE_PATH = __DIR__."/../";
const CORE_PATH = BASE_PATH . "/gear";
const ENV = "dev";
include(dirname(__FILE__, 2) . "/autoload.php");
$tcp = EzTcp::get("127.0.0.1", 8111);
$tcp->send('{"test":"a"}');
var_dump($tcp);