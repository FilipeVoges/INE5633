<?php

include_once './classes/Entity.php';
include_once './classes/Board.php';

/**
 * \AStarNode
 *
 * @author Filipe Voges <filipe.vogesh@gmail.com>
 * @since 2019-04-16
 * @version 1.0
 */
class AStarNode extends Entity {

	/**
	 * @var \Board $board
	 */
	protected $board;

    /**
	 * @var \AStarNode $previous
	 */
	protected $previous;

    /**
     * @var int $movements
     */
	protected $movements;

    /**
     * @var int $cost
     */
	protected $cost;

	/**
     * Construct Class
     *
	 * @param \Board $board
	 * @param \AStarNode $previous
	 * @param int $movements
	 * @param cost
	 */
	public function __construct(Board $board, AStarNode $previous, int $movements, int $cost) {
		parent::__construct();

        $this->set('board', $board);
        $this->set('previous', $previous);
        $this->set('movements', $movements);
        $this->set('cost', $cost);
	}

}
