<?php

namespace Mastercoding\Conquest\Command\StartingRegions;

class Pick extends \Mastercoding\Conquest\Command\AbstractCommand implements \Mastercoding\Conquest\Command\FactoryInterface
{

    /**
     * The timeout the bot has to respond
     *
     * @var int
     */
    private $timeout;

    /**
     * The region ids that we can choose from
     *
     * @var Array
     */
    private $regionIds;

    /**
     * @inheritDoc
     */
    public static function create($components)
    {

        // set timeout
        $pick = new self();
        $pick->setTimeout($components[1]);
        $pick->setRegionIds(array_slice($components, 2));
        return $pick;
        
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
     * Set region ids
     *
     * @param Array $regionIds
     */
    public function setRegionIds($regionIds)
    {
        $this->regionIds = $regionIds;
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

    /**
     * Get region ids
     *
     * @return Array
     */
    public function getRegionIds()
    {
        return $this->regionIds;
    }

}
