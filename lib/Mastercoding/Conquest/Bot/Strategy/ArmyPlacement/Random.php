<?php

namespace Mastercoding\Conquest\Bot\Strategy\ArmyPlacement;

class Random extends \Mastercoding\Conquest\Bot\Strategy\AbstractStrategy implements ArmyPlacementInterface
{

    /**
     * @inheritDoc
     */
    public function placeArmies(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\PlaceArmies $move, $amountLeft, \Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand)
    {

        // place on any of my regions
        $myRegions = $bot->getMap()->getRegionsForPlayer($bot->getMap()->getYou());

        // first
        $random = rand(0, $myRegions->count() - 1);
        $myRegions->rewind();
        for ($i = 0; $i < $random; $i++) {
            $myRegions->next();
        }

        // region
        $region = $myRegions->current();

        // moves
        $move->addPlaceArmies($region->getId(), $amountLeft);
        return array($move, 0);

    }

}
