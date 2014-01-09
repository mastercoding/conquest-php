<?php

namespace Mastercoding\Conquest\Bot\Strategy\ArmyPlacement;

interface ArmyPlacementInterface
{

    /**
     * Place armies
     *
     * @param \Mastercoding\Conquest\Bot\AbstractBot $bot
     * @param int $amountLeft
     * @param \Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand
     * @return array(\Mastercoding\Conquest\Move\PlaceArmies, $amountLeft)
     * 
     */
    public function placeArmies(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\PlaceArmies $move, $amountLeft, \Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand);

}
