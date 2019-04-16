<?php 

include_once 'Entity.php';

/**
 * \Tree
 *
 * @author Filipe Voges <filipe.vogesh@gmail.com>
 * @since 2019-04-11
 * @version 1.0
 */
class Tree extends Entity {
  /**
   * @var \Board $board
   */
	protected $board;
  
	/**
	 * array $nodes
	 */
	protected $nodes;	
}
