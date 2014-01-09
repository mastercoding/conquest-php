<?php

namespace Mastercoding\Conquest\Move;

class AttackTransfer extends AbstractMove
{
    /**
     * regions to attack
     *
     * @var Array (regionFromId, regionToId, armies)
     */
    private $attacks;

    /**
     *
     * Add attack/transfer
     *
     * @param int $regionFromId
     * @param int $regionToId
     * @param int $armies
     */
    public function addAttackTransfer($regionFromId, $regionToId, $armies)
    {
        $this->attacks[] = array('regionFromId' => $regionFromId, 'regionToId' => $regionToId, 'armies' => $armies);
        return $this;
    }

    /**
     * Convert to string
     */
    public function toString()
    {

        $regions = array();
        foreach ($this->attacks as $attack) {
            $regions[] = sprintf('{{player_name}} attack/transfer %d %d %d', (int)$attack['regionFromId'], (int)$attack['regionToId'], (int)$attack['armies']);
        }
        
        $string = implode(',', $regions);
        return $this->expandPlayerName($string);

    }

}