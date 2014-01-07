<?php

namespace Mastercoding\Conquest\Command\Settings;

class StartingArmies extends \Mastercoding\Conquest\Command\AbstractCommand implements \Mastercoding\Conquest\Command\FactoryInterface

{

    /**
     * Amount of starting armies
     *
     * @var int
     */
    private $amount;

    /**
     * @inheritDoc
     */
    public static function create($components)
    {
        return new self($components[2]);
    }

    /**
     * Construct with amount
     *
     * @param int $amount
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

}
