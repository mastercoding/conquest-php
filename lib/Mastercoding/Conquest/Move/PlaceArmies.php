<?php

namespace Mastercoding\Conquest\Move;

class PlaceArmies extends AbstractMove
{
    /**
     * regions to place armies upon
     *
     * @var Array (id => amount)
     */
    private $regions = array();

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

            $regions[] = sprintf('{{player_name}} place_armies %d %d', (int)$regionId, (int)$armies);

        }

        $string = implode(',', $regions);
        return $this->expandPlayerName($string);

    }

}
