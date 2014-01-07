<?php

namespace Mastercoding\Conquest\Bot;

class SimpleBot extends AbstractBot
{

    /**
     * @inheritDoc
     */
    public function pickRegions(\Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand)
    {
        return new \Mastercoding\Conquest\Move\PickRandomRegions;
    }

    /**
     * @inheritDoc
     */
    public function placeArmies(\Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand)
    {

        // get amount to place
        $amount = $this->getMap()->getStartingArmies();

        // place on any of my regions
        $myRegions = $this->getMap()->getRegionsForPlayer($this->getMap()->getYou());

        // first
        $myRegions->rewind();
        $first = $myRegions->current();

        // moves
        $placeArmiesMove = new \Mastercoding\Conquest\Move\PlaceArmies;
        $placeArmiesMove->addPlaceArmies($first->getId(), $amount);
        return $placeArmiesMove;

    }

    /**
     * @inheritDoc
     */
    public function attackTransfer(\Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand)
    {
        return new \Mastercoding\Conquest\Move\NoMove();
    }

}
