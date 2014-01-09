<?php

namespace Mastercoding\Conquest\Move;

class PickRegions extends AbstractMove
{

    /**
     * The region ids to pick
     *
     * @var Array
     */
    private $regionIds;
    
    public function __construct()
    {
        $this->regionIds = array();   
    }
    
    /**
     * Set region ids
     *
     * @param Array $regionIds
     */
    public function setRegionIds(Array $regionIds)
    {
        $this->regionIds = $regionIds;
        return $this;
    }
    
    /**
     * Add region id
     *
     * @param int $regionId
     */
    public function addRegionId($regionId)
    {
        $this->regionIds[] = $regionId;
        return $this;
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

    /**
     * To string, this command just expects space seperated ids
     */
    public function toString()
    {
        return implode(' ', $this->getRegionIds());
    }

}