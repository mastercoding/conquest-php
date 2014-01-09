<?php

namespace Mastercoding\Conquest\Bot\Strategy\ArmyPlacement;

class AllOnOne extends \Mastercoding\Conquest\Bot\Strategy\AbstractStrategy implements ArmyPlacementInterface
{

    /**
     * @inheritDoc
     */
    public function placeArmies(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\PlaceArmies $move, $amountLeft, \Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand)
    {

        // place on any of my regions
        $myRegions = $bot->getMap()->getRegionsForPlayer($bot->getMap()->getYou());

        // first
        $myRegions->rewind();
        $first = $myRegions->current();

        // moves
        $move->addPlaceArmies($first->getId(), $amountLeft);
        return array($move, 0);

    }

}