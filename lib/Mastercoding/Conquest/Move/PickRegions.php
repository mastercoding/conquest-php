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