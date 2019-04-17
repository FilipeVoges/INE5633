<?php

include_once 'classes/Entity.php';
include_once 'classes/Board.php';
include_once 'HManhattan.php';
include_once 'AStarNode.php';

/**
 * \AStar
 * Algoritmo A*
 *
 * @author Filipe Voges <filipe.vogesh@gmail.com>
 * @since 2019-04-16
 * @version 1.0
 */
class AStar extends Entity {

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

	/**
	 * Busca
	 *
	 * @param \Board $begin
	 * @return void
	 */
	public function starSearch(Board $begin) {
		$initialNode = new AStarNode($begin, NULL, 0, HManhattan::calc($begin));
		$actualNode = $finalNode = $savedNode = NULL;

		$this->openList[$initialNode->get('identifier')] = $initialNode;

		while(!empty($this->get('openList'))) {

			$actualNode = $this->minOpenList();

			if($actualNode->get('board')->isSolution()) break;

			$this->closedList[$actualNode->get('identifier')] = $actualNode;
			if(isset($this->openList[$actualNode->get('identifier')])) unset($this->openList[$actualNode->get('identifier')]);

			foreach ($actualNode->get('board')->getBoardSuccessors() as $key => $board) {
				$heuristic = HManhattan::calc($board);
				if(!is_null($actualNode->get('previous'))) {
					if (!$actualNode->get('previous')->get('board')->equals($board)) {
						if(($savedNode = $this->findBoardClosedList($board)) != NULL) {
							if($heuristic + $actualNode->get('movements') < $savedNode->get('cost') + $savedNode->get('movements')) {
								if(isset($this->closedList[$savedNode->get('identifier')])) unset($this->closedList[$savedNode->get('identifier')]);
								if(is_null($this->findBoardInOpenList($board))) {
									$finalNode = new AStarNode($board, $actualNode, $actualNode->get('movements') + 1, $heuristic);
									$this->openList[$finalNode->get('identifier')] = $finalNode;
								}
							}
						}elseif(($savedNode = $this->findBoardInOpenList($board)) != NULL) {
							if($heuristic + $actualNode->get('movements') < $savedNode->get('cost')  + $savedNode->get('movements')) {
								if(isset($this->openList[$savedNode->get('identifier')])) unset($this->openList[$savedNode->get('identifier')]);

								$finalNode = new AStarNode($board, $actualNode, $actualNode->get('movements') + 1, $heuristic);
								$this->openList[$finalNode->get('identifier')] = $finalNode;
							}
						}else{
							$finalNode = new AStarNode($board, $actualNode, $actualNode->get('movements') + 1, $heuristic);
							$this->openList[$finalNode->get('identifier')] = $finalNode;
						}
					}
				}else{
					$finalNode = new AStarNode($board, $actualNode, $actualNode->get('movements') + 1, $heuristic);
					$this->openList[$finalNode->get('identifier')] = $finalNode;
				}
			}
		}

		if($actualNode->get('board')->isSolution()){
			$temp = $actualNode;
			$steps = $actualNode->get('movements');
			var_dump($steps); die();
			if(is_null($temp->get('previous'))){
				$this->solution[$temp->get('board')->get('identifier')] = $temp->get('board');
			}else{
				while(!is_null($temp->get('previous'))) {
					$this->solution[$temp->get('board')->get('identifier')] = $temp->get('board');
					$temp = $temp->get('previous');
				}
			}

		}
	}

	/**
	 * Busca o nó com o menor custo na lista com os nó aberto
	 *
	 * @return \AStarNode
	 */
	public function minOpenList() {
		$min = NULL;

		foreach ($this->openList as $key => $node) {
			if(is_null($min)){
				$min = $node;
			}elseif($min->get('cost') > $node->get('cost')){
				$min = $node;
			}
		}

		return $min;
	}

	/**
	 * Verifica se um Tabuleiro esá na lista de Nós Abertos e retorna o Nó
	 *
	 * @param \Board $board
	 * @return \AStarNode
	 */
	public function findBoardInOpenList(Board $board) {
		foreach ($this->openList as $key => $node) {
			if($node->get('board')->equals($board)) return $node;
		}

		return NULL;
	}

	/**
	  * Verifica se um Tabuleiro esá na lista de Nós Fechados e retorna o Nó
 	 *
 	 * @param \Board $board
 	 * @return \AStarNode
	 */
	public function findBoardClosedList(Board $board) {
		foreach ($this->closedList as $key => $node) {
			if($node->get('board')->equals($board)) return $node;
		}

		return NULL;
	}

}
