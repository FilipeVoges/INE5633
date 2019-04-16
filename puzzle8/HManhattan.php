<?php

include_once './classes/Board.php';

/**
 * \HManhattan
 *
 * @author Filipe Voges <filipe.vogesh@gmail.com>
 * @since 2019-04-16
 * @version 1.0
 */
class HManhattan {

    /**
	 * Heuristic Manhattan.
	 * Returns the value of Manhattan heuristic for the state board.
	 * The heuristic value of Manhattan is equal to the sum of the
	 * differences between the current line number and column minus
	 * the number of row and column where the piece should be (absolute value)
	 * of all the pieces to their correct positions.
	 *
	 * @param Board $board
	 * @return int
	 */
    public static function calc(Board $board) {
		$manhattan = 0;

        foreach ($board->get('pieces') as $key => $p) {
            $temp = 0;

            $position = $p->get('position');

            $line = $position->get('x');
            $column = $position->get('y');
			if (is_null($p->get('number'))) {
				$temp = abs($line - 2);
				$temp += abs($column - 2);
			}elseif($p->get('number') == 1) {
				$temp = $line;
				$temp += $column;
			}elseif($p->get('number') == 2) {
				$temp = $line;
				$temp += abs($column - 1);
			}elseif($p->get('number') == 3) {
				$temp = $line;
				$temp += abs($column - 2);
			}elseif($p->get('number') == 4) {
				$temp = abs($line - 1);
				$temp += $column;
			}elseif($p->get('number') == 5) {
				$temp = abs($line - 1);
				$temp += abs($column - 1);
			}elseif($p->get('number') == 6) {
				$temp = abs($line - 1);
				$temp += abs($column - 2);
			}elseif($p->get('number') == 7) {
				$temp = abs($line - 2);
				$temp += $column;
			}elseif($p->get('number') == 8) {
				$temp = abs($line - 2);
				$temp += abs($column - 1);
			}

			$manhattan += $temp;
		}

		return $manhattan;
	}

}
