<?php

namespace Mastercoding\Conquest\Command\Info;

class StartingArmies extends \Mastercoding\Conquest\Command\AbstractCommand implements \Mastercoding\Conquest\Command\FactoryInterface
{

    /**
     * The visible moves the opponent made
     *
     * @var int
     */
    private $regionId;

    /**
     * @inheritDoc
     */
    public static function create($components)
    {

        // set timeout
        $armies = new self();
        return $armies;

    }

    /**
     * Construct
     */
    public function __construct()
    {
    }

}