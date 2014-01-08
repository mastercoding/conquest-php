<?php

namespace Mastercoding\Conquest\Bot\Strategy\ArmyPlacement;

class AllOnOne implements ArmyPlacementInterface
{

    /**
     * @inheritDoc
     */
    public function placeArmies(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand)
    {

        // get amount to place
        $amount = $bot->getMap()->getStartingArmies();

        // place on any of my regions
        $myRegions = $bot->getMap()->getRegionsForPlayer($bot->getMap()->getYou());

        // first
        $myRegions->rewind();
        $first = $myRegions->current();

        // moves
        $placeArmiesMove = new \Mastercoding\Conquest\Move\PlaceArmies;
        $placeArmiesMove->addPlaceArmies($first->getId(), $amount);
        return $placeArmiesMove;

    }

}