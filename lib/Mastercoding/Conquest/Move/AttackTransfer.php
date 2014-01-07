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
     * @param \Mastercoding\Conquest\Object\Region $regionFrom
     * @param \Mastercoding\Conquest\Object\Region $regionTo
     * @param int $armies
     */
    public function addAttackTransfer(\Mastercoding\Conquest\Object\Region $regionFrom, \Mastercoding\Conquest\Object\Region $regionTo, $armies)
    {
        $this->attacks[] = array('regionFromId' => $regionFrom->getId(), 'regionToId' => $regionTo->getId(), 'armies' => $armies);
        return $this;
    }

    /**
     * Convert to string
     */
    public function toString()
    {

        $regions = array();
        foreach ($this->attacks as $attack) {
            $regions[] = sprintf('{{you}} attack/transfer %d %d %d', (int)$attack['regionFromId'], (int)$attack['regionToId'], (int)$attack['armies']);
        }

        return implode(',', $regions);
    }

}
