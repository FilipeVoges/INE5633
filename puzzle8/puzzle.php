<?php

//header("HTTP/1.1 501");
//echo "<strong>501</strong> - Not Implemented";

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'classes/Position.php';

$a = new Position(1, 1);
echo '<pre>';
var_dump($a);	
echo '</pre>';
echo '<hr>';
$b = new Position(1, 2);
echo '<pre>';
var_dump($b);	
echo '</pre>';
