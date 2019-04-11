<?php

include_once './Entity.php';

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
}
