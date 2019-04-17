<?php

include_once 'Entity.php';
include_once 'Piece.php';
include_once 'Position.php';

/**
 * \Board
 *
 * @author Filipe Voges <filipe.vogesh@gmail.com>
 * @since 2019-04-11
 * @version 1.0
 */
class Board extends Entity{

    /**
     * @var int $level
     */
	protected $level;

    /**
     * @var \Position
     */
	protected $position;

	/**
     * @var array
     */
	protected $pieces;

    /**
     * @var \Piece
     */
	protected $emptyPiece;

    /**
     * @var \Board
     */
	protected $father;

    /**
     * @var array
     */
	protected $successors;

    /**
     * @var bool
     */
	protected $flagOpen;

    /**
     * Constructor Class
     *
	 * @param \Board $game
     * @param array $pieces
     * @param \Piece $emptyPiece
     * @param int $level
     * @param \Board $father
     */
    public function __construct(Board $game = NULL, array $pieces = [], Piece $emptyPiece = NULL, int $level = 0, Board $father = NULL){
        parent::__construct();

		if(!is_null($game) && !empty($game->get('pieces'))){
			$pieces = [];
			foreach ($game->get('pieces') as $key => $p) {
				if(!is_null($p->get('number'))){
					$nP = new Piece($p);
					$pieces[$nP->get('identifier')] = $nP;
				}else{
					$nP = new Piece($p);
					$pieces[$nP->get('identifier')] = $nP;
					$this->set('emptyPiece', $nP);
				}
			}
			$this->set('pieces', $pieces);
			if(is_null($this->get('emptyPiece'))){
				$emptyHouseOld = $game->get('emptyPiece')->get('boardHouse');
				foreach ($pieces as $key => $p) {
					if($p->get('boardHouse') == $emptyHouseOld){
						$this->set('emptyPiece', $p);
						break;
					}
				}
			}
		}else {
			$this->set('level', $level);
			if(is_null($this->get('successors'))){
				$this->set('successors', []);
			}
			if(is_null($this->get('flagOpen'))){
				$this->set('flagOpen', true);
			}
			if(!is_null($emptyPiece)){
				$this->set('emptyPiece', $emptyPiece);
			}
			if(!empty($pieces)){
				$this->set('pieces', $pieces);
			}
			if(!is_null($father)){
				$this->set('father', $father);
			}

			$pieces = !is_null($this->get('pieces')) ? $this->get('pieces') : [];
			usort($pieces, 'Board::cmp');
		}

    }


	/**
	 * Reoderna o Tabuleiro
	 *
	 * @param \Piece $p1
	 * @param \Piece $p2
	 * @return int
	 */
	private static function cmp(Piece $p1, Piece $p2){
		if($p1->get('boardHouse') > $p2->get('boardHouse')){
			return 1;
		}elseif($p1->get('boardHouse') < $p2->get('boardHouse')) {
			return -1;
		}else{
			return 0;
		}
	}
	/**
	 * Verifica se é a solução do game
	 *
	 * Solution:
	 *
	 * 		1 2 3
	 * 		4 5 6
	 * 		7 8 0
	 *
	 * @return bool
	 */
	public function isSolution(){
		foreach ($this->get('pieces') as $key => $p) {
			if(!$p->isCorrectPlace()) return false;
		}
		return true;
	}

	/**
	 * Retorna uma lista de posições onde cada peça representa uma sequência possível após mover as peças que podem ser movidas para a posição em branco.
	 *
	 * @return array
	 */
	public function getBoardSuccessors() {
		$pieces = $successors = [];

		$game = new Board($this);
		echo (string)$game . "<hr>";

		$pieces = $game->piecesThatCanMove();
		foreach ($pieces as $key => $p) {
			$game->movePiece($p);

			$successors[$game->get('identifier')] = $game;

			$game = new Board($this);
			echo (string)$game;
			$pieces = $game->piecesThatCanMove();
		}
		die();
		return $successors;
	}

	/**
	 * Retorna uma lista com as possíveis peças que estão se movendo
	 *
	 * @return array
	 */
	public function piecesThatCanMove() {
		$piecesThatCanMove = [];

		$eP = $this->get('emptyPiece');
		$pieces = $this->get('pieces');
		$house = $eP->get('boardHouse');
		foreach ($pieces as $key => $p) {
			if(in_array($house, $p->possiblesHouse()) && $p->get('boardHouse') != $house) {
				$piecesThatCanMove[$p->get('identifier')] = $p;
			}
		}

		return $piecesThatCanMove;
	}

	/**
	 * Move uma peça
	 *
	 * @return void
	 */
	public function movePiece(Piece $piece) {
		$this->updatePiecePosition($piece);
	}

	/**
	 * Atualiza a posição da peça
	 *
	 * @return void
	 */
	private function updatePiecePosition(Piece $piece) {
		$emptyPiece = $this->get('emptyPiece');
		$positionEmpty = $emptyPiece->get('position');

		$pieces = $this->get('pieces');
		$emptyPiece->set('position', new Position($piece->get('position')->get('x'), $piece->get('position')->get('y')));
		$emptyPiece->updateBoardHouse();

		$piece->set('position', $positionEmpty);
		$piece->updateBoardHouse();

		$pieces[$piece->get('identifier')] = $this->get('emptyPiece');
		$pieces[$emptyPiece->get('identifier')] = $piece;
		usort($pieces, 'Board::cmp');
		$this->set('pieces', $pieces);
		$this->set('emptyPiece', $emptyPiece);
	}

	public function __toString(){
		$pieces = [];

		$ps = $this->get('pieces');
		$idx = 0;
		for ($i = 0; $i < 3; $i++) {
			$pTmp = array_slice($ps, $idx, 3, true);
			$idx += 3;
			$pieces[] = $pTmp;
		}
		$content = '<table style="border: 1px solid black;">';
		foreach ($pieces as $key => $line) {
			$content .= '<tr>';
			foreach ($line as $key => $p) {
				$content .= '<td> ' . $p->get('number') . ' </td>';
			}
			$content .= '</tr>';
		}
		$content .= '</table>';

		return $content;
	}

}
