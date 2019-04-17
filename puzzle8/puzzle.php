<?php

//header("HTTP/1.1 501"); tipo Funcionario e Gerente extenderiam a
//echo "<strong>501</strong> - Not Implemented";

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'classes/Board.php';
require_once 'classes/Piece.php';
require_once 'classes/Position.php';
require_once 'AStar.php';


$initialBoard = new Board();

$element1 = new Piece(NULL, 2, new Position(0, 0));
$element2 = new Piece(NULL, 1, new Position(0, 1));
$element3 = new Piece(NULL, 4, new Position(0, 2));
$element4 = new Piece(NULL, 3, new Position(1, 0));
$element5 = new Piece(NULL, 6, new Position(1, 1));
$element6 = new Piece(NULL, 5, new Position(1, 2));
$element7 = new Piece(NULL, 8, new Position(2, 0));
$element8 = new Piece(NULL, 7, new Position(2, 1));
$element9 = new Piece(NULL, 9, new Position(2, 2));

$pieces = $initialBoard->get('pieces');

$pieces[$element1->get('identifier')] = $element1;
$pieces[$element2->get('identifier')] = $element2;
$pieces[$element3->get('identifier')] = $element3;
$pieces[$element4->get('identifier')] = $element4;
$pieces[$element5->get('identifier')] = $element5;
$pieces[$element6->get('identifier')] = $element6;
$pieces[$element7->get('identifier')] = $element7;
$pieces[$element8->get('identifier')] = $element8;
$pieces[$element9->get('identifier')] = $element9;

$initialBoard->set('pieces', $pieces);
$initialBoard->set('emptyPiece', $element8);


$aStar = new AStar();
$aStar->starSearch($initialBoard);
var_dump($aStar); die();
