<?php

//header("HTTP/1.1 501");
//echo "<strong>501</strong> - Not Implemented";

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'AStar.php';

$aStar = new AStar();
var_dump($aStar);
