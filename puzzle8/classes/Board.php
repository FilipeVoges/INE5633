<?php

include_once './Entity.php';

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
    public function __construct(Board $game = NULL, array $pieces = [], Piece $emptyPiece = NULL, int $level = 0, Board $father == NULL){
        parent::__construct();

		if(!is_null($game) && !empty($game->get('pieces'))){
			$pieces = [];

			foreach ($game->get('pieces') as $key => $p) {
				if(!is_null($p->get('number'))){
					$pieces[] = new Piece($p);
				}else{
					$nP = new Piece($p);
					$pieces[] = $nP;
					$this->set('emptyElement', $nP);
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


			usort($this->get('pieces'), function(Piece $p1, Piece $p2){
				if($p1->get('boardHouse') > $p2->get('boardHouse')){
					return 1;
				}elseif($p1->get('boardHouse') < $p2->get('boardHouse')) {
					return -1;
				}else{
					return 0;
				}
			});
		}

    }



	/**
	 * Verifica se é a solução do game
	 *
	 * Solution:
	 *
	 * 		1 2 3
	 * 		4 5 6
	 * 		8 9 0
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

		$pieces = $game->piecesThatCanMove();

		foreach ($pieces as $key => $p) {
			$game->movePiece($p);

			$successors[] = $game;

			$game = new Board($this);
			$pieces = $game->piecesThatCanMove();
		}

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
		$position = $eP->get('position');

		$pieces = $this->get('pieces');
		if ($position->get('x') - 1 >= 0){
			$piecesThatCanMove[] = $pieces[(($position->get('x') - 1) * 3) + $position->get('y')];
		}
		if (($position->get('x') + 1) * 3 < count($pieces)){
			$piecesThatCanMove[] = $pieces[(($position->get('x') + 1) * 3) + $position->get('y')];
		}
		if ($position->get('y') - 1 >= 0){
			$piecesThatCanMove[] = $pieces[($position->get('x') * 3) + ($position->get('y') - 1)];
		}
		if ($position->get('y') + 1 < 3){
			$piecesThatCanMove[] = $pieces[($position->get('x') * 3) + ($position->get('y') + 1)];
		}

		return $piecesThatCanMove;
	}
	
	/**
	 * Move uma peça
	 *
	 * @return void
	 */
	public function movePiece(Piece $piece) {
		$position = $piece->get('position');
		$positionEmpty = $this->get('emptyPiece')->get('position');
		$validation = ($position->get('x') == $positionEmpty->get('x') && ($position->get('y') == $positionEmpty->get('y') - 1 || $position->get('y') == $positionEmpty->get('y') + 1))
			|| (($position->get('x') == $positionEmpty->get('x') - 1 || $position->get('x') == $positionEmpty->get('x') + 1) && $position->get('y') == $positionEmpty->get('y'));
		if ($validation) {
			$this->updatePiecePosition($piece);
		}
	}
	
	/**
	 * Atualiza a posição da peça
	 *
	 * @return void
	 */
	public function updatePiecePosition(Piece $piece) {
		$positionEmpty = $this->get('emptyPiece')->get('position');
		$line = $positionEmpty->get('x');
		$column = $positionEmpty->get('y');

		$pieces = $this->get('pieces');

		$positionEmpty = new Position($position->get('x'), $position->get('y'));
		$this->get('emptyPiece')->set('position', $positionEmpty);

		$position = new Position($line, $column);
		$piece->set('position', $position);

		unset($pieces[($position->get('x') * 3) + $position->get('y')]);
		$pieces[($position->get('x') * 3) + $position->get('y')] = $this->get('emptyPiece');

		unset($pieces[($line * 3) + $column]);
		$pieces[($line * 3) + $column] = $piece;

		$this->set('pieces', $pieces);
	}
}
