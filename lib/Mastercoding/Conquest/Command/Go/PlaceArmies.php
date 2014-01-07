<?php

namespace Mastercoding\Conquest\Command\Go;

class PlaceArmies extends \Mastercoding\Conquest\Command\AbstractCommand implements \Mastercoding\Conquest\Command\FactoryInterface
{

    /**
     * The timeout the bot has to respond
     *
     * @var int
     */
    private $timeout;

    /**
     * @inheritDoc
     */
    public static function create($components)
    {

        // set timeout
        $placeArmies = new self();
        $placeArmies->setTimeout($components[2]);
        return $placeArmies;
        
    }

    /**
     * Construct
     */
    public function __construct()
    {
    }

    /**
     * Set timoeut
     *
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * Get timoeut
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

}