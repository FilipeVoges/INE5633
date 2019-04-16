<?php

include_once './classes/Board.php';
include_once './HManhattan.php';

/**
 * \AStar
 * Algoritmo A*
 *
 * @author Filipe Voges <filipe.vogesh@gmail.com>
 * @since 2019-04-16
 * @version 1.0
 */
class AStar {
	
	/**
     * @var array
     */
	protected $openList;

    /**
     * @var array
     */
	protected $closedList;

    /**
     * @var array
     */
	protected $solution;

    /**
     * @var int
     */
	protected $steps;

	/**
     * Consatruct Class
     */
    public function __construct(){
        parent::__construct();

        $this->set('openList', []);
        $this->set('closedList', []);
        $this->set('solution', []);
        $this->set('steps', 0);
    }
}
