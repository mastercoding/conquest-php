<?php

namespace Mastercoding\Conquest\Command\Info;

class Region extends \Mastercoding\Conquest\Command\AbstractCommand implements \Mastercoding\Conquest\Command\FactoryInterface
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
        $armies->setRegionId($components[2]);
        return $armies;

    }

    /**
     * Construct
     */
    public function __construct()
    {
    }

    /**
     * Set region id
     *
     * @param int $regionId
     */
    public function setRegionId($regionId)
    {
        $this->regionId = $regionId;
        return $this;
    }

    /**
     * Get region id
     *
     * @return int
     */
    public function getRegionId()
    {
        return $this->regionId;
    }

}
