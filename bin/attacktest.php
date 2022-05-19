<?php
include(dirname(__FILE__, 2) . "/autoload.php");

//echo CharacterConst::getExp(60);
$basicAttr = new BasicAttribute();
$basicAttr2 = new BasicAttribute();
$p1 = new SwordsMan();
$p1->init($basicAttr);
$p2 = new SwordsMan();
$p2->init($basicAttr2);


$p1->attack($p2);
$p2->attack($p1);