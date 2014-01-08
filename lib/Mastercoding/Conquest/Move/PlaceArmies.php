<?php

namespace Mastercoding\Conquest\Move;

class PlaceArmies extends AbstractMove
{
    /**
     * regions to place armies upon
     *
     * @var Array (id => amount)
     */
    private $regions;

    /**
     *
     * Add place armies
     *
     * @param int $regionId
     * @param int $armies
     */
    public function addPlaceArmies($regionId, $armies)
    {
        $this->regions[$regionId] = $armies;
        return $this;
    }

    /**
     * Convert to string
     */
    public function toString()
    {

        $regions = array();
        foreach ($this->regions as $regionId => $armies) {

            $regions[] = sprintf('{{you}} place_armies %d %d', (int)$regionId, (int)$armies);

        }

        return implode(',', $regions);
    }

}
