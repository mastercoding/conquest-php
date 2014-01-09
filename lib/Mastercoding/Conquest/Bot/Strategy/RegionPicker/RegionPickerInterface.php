<?php

namespace Mastercoding\Conquest\Bot\Strategy\RegionPicker;

interface RegionPickerInterface
{

    /**
     * Pick the starting regions for the map from some possible regions
     *
     * @param \Mastercoding\Conquest\Bot\AbstractBot $bot
     * @param \Mastercoding\Conquest\Move\PickRegions $move
     * @param int $amountLeft
     * @param \Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand
     * @return array(\Mastercoding\Conquest\Move\PickRegions|\Mastercoding\Conquest\Move\PickRandomRegions, 0)
     */
    public function pickRegions(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\PickRegions $move, $amountLeft, \Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand);

}