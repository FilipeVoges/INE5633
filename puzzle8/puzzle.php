<?php

//header("HTTP/1.1 501");
//echo "<strong>501</strong> - Not Implemented";

include_once './classes/Position.php';

$a = new Position(1, 1);
var_dump($a->get('identifier');
$a = new Position(1, 2);
var_dump($a->get('identifier');
$a = new Position(1, 3);
var_dump($a->get('identifier');
$a = new Position(2, 1);
var_dump($a->get('identifier');
$a = new Position(2, 2);
var_dump($a->get('identifier');
$a = new Position(2, 3);
var_dump($a->get('identifier');
$a = new Position(3, 1);
var_dump($a->get('identifier');
$a = new Position(3, 2);
var_dump($a->get('identifier');
$a = new Position(3, 3);
var_dump($a->get('identifier');
