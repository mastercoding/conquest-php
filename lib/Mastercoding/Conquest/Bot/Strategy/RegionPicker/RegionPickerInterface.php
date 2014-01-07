<?php

namespace Mastercoding\Conquest\Bot\Strategy\RegionPicker;

interface RegionPickerInterface
{

    /**
     * Pick the starting regions for the map from some possible regions
     *
     * @param \Mastercoding\Conquest\Bot\AbstractBot $bot
     * @param \Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand
     * @return
     * \Mastercoding\Conquest\Move\PickRegions|\Mastercoding\Conquest\Move\PickRandomRegions
     */
    public function pickRegions(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand);

}
