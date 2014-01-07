<?php

namespace Mastercoding\Conquest\Bot\Strategy\ArmyPlacement;

interface ArmyPlacementInterface
{

    /**
     * Place armies
     *
     * @param \Mastercoding\Conquest\Bot\AbstractBot $bot
     * @param \Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand
     * @return
     * \Mastercoding\Conquest\Move\PlaceArmies
     */
    public function placeArmies(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand);

}