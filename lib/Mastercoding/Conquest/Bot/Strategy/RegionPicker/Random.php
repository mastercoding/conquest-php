<?php

namespace Mastercoding\Conquest\Bot\Strategy\RegionPicker;

class Random implements RegionPickerInterface
{

    /**
     * @inheritDoc
     */
    public function pickRegions(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand)
    {
        return new \Mastercoding\Conquest\Move\PickRandomRegions();
    }

}