<?php

namespace Mastercoding\Conquest\Command\OpponentMoves;

class Moves extends \Mastercoding\Conquest\Command\AbstractCommand implements \Mastercoding\Conquest\Command\FactoryInterface
{

    /**
     * The visible moves the opponent made
     *
     * @var int
     */
    private $moves;

    /**
     * @inheritDoc
     */
    public static function create($components)
    {

        // set timeout
        $moves = new self();

        // the updates
        $actualMoves = array();


    }

    /**
     * Construct
     */
    public function __construct()
    {
        $this->updates = array();
    }

    /**
     * Set region ids
     *
     * @param Array $regionIds
     */
    public function setUpdates($updates)
    {
        $this->updates = $updates;
        return $this;
    }

    /**
     * Get updates ids
     *
     * @return Array
     */
    public function getUpdates()
    {
        return $this->updates;
    }

}
