<?php

include_once 'Entity.php';
include_once 'Postion.php';

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
	 * @param \Postion $position
	 */
	public function __construct(Piece $piece = NULL, int $number = 0, Postion $position = NULL){
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
}
