<?php

namespace Mastercoding\Conquest\Move;

class AttackTransfer extends AbstractMove
{
    /**
     * regions to attack
     *
     * @var Array (regionFromId, regionToId, armies)
     */
    private $attacks = array();

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
     * Get attack transfers
     *
     * @return array
     */
    public function getAttackTransfer()
    {
        return $this->attacks;
    }

    /**
     * Convert to string
     */
    public function toString()
    {
        // no moves?
        if (empty($this->attacks)) {

            // no
            $noMoves = new \Mastercoding\Conquest\Move\NoMove;
            return $noMoves->toString();

        }

        $regions = array();
        foreach ($this->attacks as $attack) {
            $regions[] = sprintf('{{player_name}} attack/transfer %d %d %d', (int)$attack['regionFromId'], (int)$attack['regionToId'], (int)$attack['armies']);
        }

        $string = implode(',', $regions);
        return $this->expandPlayerName($string);

    }

}
