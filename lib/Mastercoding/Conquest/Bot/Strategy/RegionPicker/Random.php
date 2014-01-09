<?php

namespace Mastercoding\Conquest\Bot\Strategy\RegionPicker;

class Random extends \Mastercoding\Conquest\Bot\Strategy\AbstractStrategy implements RegionPickerInterface
{

    /**
     * @inheritDoc
     */
    public function pickRegions(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\PickRegions $move, $amountLeft, \Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand)
    {

        // choices
        $choices = array_diff($pickCommand->getRegionIds(), $move->getRegionIds());

        // only pick random if amount left is 6, because issues otherwise
        $random = array_rand($choices, $amountLeft);
        foreach ($random as $key) {
            $move->addRegionId($choices[$key]);
        }

        return array($move, 0);
    }

}
