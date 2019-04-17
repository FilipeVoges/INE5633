<?php

include_once 'Entity.php';
include_once 'Position.php';

/**
 * \Piece
 *
 * @author Filipe Voges <filipe.vogesh@gmail.com>
 * @since 2019-04-11
 * @version 1.0
 */
class Piece extends Entity {

	/**
	 * @var int $number
	 */
	protected $number;

	/**
	  * @var int $number
	 */
	protected $boardHouse;

	/**
	 * @var \Position
	 */
	protected $position;

	/**
	 * Constructor Class
	 *
	 * @param \Piece $piece
	 * @param int $number
	 * @param \Position $position
	 */
	public function __construct(Piece $piece = NULL, int $number = NULL, Position $position = NULL){
		parent::__construct();

		if(!is_null($piece)){
			$this->set('number', $piece->get('number'));
			$this->set('boardHouse', $piece->get('position')->getBoardHouse());
			$this->set('position', $piece->get('position'));
		}else{
			$this->set('number', $number);
			$this->set('boardHouse', $position->getBoardHouse());
			$this->set('position', $position);
		}
	}

	/**
	* Verifica se a Peça está na casa correta
	*
	* @return bool
	*/
	public function isCorrectPlace(){
		if(!is_null($this->get('number')) && $this->get('number') == $this->get('boardHouse')) return true;
		if(is_null($this->get('number')) && $this->get('boardHouse') == 9) return true;

		return false;
	}

	/**
	 * Atualiza a Casa da Peça
	 *
	 * @return void
	 */
	public function updateBoardHouse(){
		$this->set('boardHouse', $this->get('position')->getBoardHouse());
	}

	/**
	 * Retorna para quais casas a peça pode se mover
	 *
	 * @return array
	 */
	public function possiblesHouse(){
		$houses = [];

		switch ($this->get('boardHouse')) {
			case 9 :
				$houses = [8, 6];
				break;
			case 8 :
				$houses = [7, 5, 9];
				break;
			case 7 :
				$houses = [8, 4];
				break;
			case 6 :
				$houses = [9, 5, 3];
				break;
			case 5 :
				$houses = [2, 4, 6, 8];
				break;
			case 4 :
				$houses = [1, 5, 7];
				break;
			case 3 :
				$houses = [2, 6];
				break;
			case 2 :
				$houses = [1, 5, 3];
				break;
			case 1 :
			default :
				$houses = [2, 4];
				break;
		}

		return $houses;
	}
}
