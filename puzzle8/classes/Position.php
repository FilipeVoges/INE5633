<?php

include_once 'Entity.php';

/**
 * \Position
 *
 * @author Filipe Voges <filipe.vogesh@gmail.com>
 * @since 2019-04-11
 * @version 1.0
 */
class Position extends Entity{

    /**
     * @var int $x;
     */
    protected $x;

    /**
     * @var int $y;
     */
    protected $y;

    /**
     * Construct Class
     *
     * @param int $x
     * @param int $y
     */
    public function __construct(int $x, int $y){
        parent::__construct();

        $this->set('x', $x);
        $this->set('y', $y);
    }
	
	/**
	* Retorna a casa correspondente de uma Posição
	*
	* @return int
	*/
	public function getBoardHouse(){
		$line = $this->get('x');
		$column = $this->get('y');
		if($line == 0 && $column == 0){
			return 1;
		}elseif($line == 0 && $column == 1){
			return 2;
		}elseif($line == 0 && $column == 2){
			return 3;
		}elseif($line == 1 && $column == 0){
			return 4;
		}elseif($line == 1 && $column == 1){
			return 5;
		}elseif($line == 1 && $column == 2){
			return 6;
		}elseif($line == 2 && $column == 0){
			return 7;
		}elseif($line == 2 && $column == 1){
			return 8;
		}elseif($line == 2 && $column == 2){
			return 9;
		}
	}

}
