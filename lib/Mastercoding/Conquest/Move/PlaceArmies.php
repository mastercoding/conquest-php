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

    public function addPlaceArmies(Region $region, $armies)
    {

        $this->regions[$region->getId()] = $armies;

    }
    
    /**
     * Conver to string
     */
    public function toString()
    {

        $regions = array();
        foreach ($this->Regions as $regionId => $armies) {

            $regions[] = sprintf('{{you}} place_armies %d %d', (int)$regionId, (int)$armies);

        }

        return implode(',', $regions);
    }

}
