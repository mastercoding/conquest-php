<?php

namespace Mastercoding\Conquest\Bot\Strategy\RegionPicker;

/**
 * Pick regions on as many different continents as possible
 */
class Spread implements RegionPickerInterface
{

    /**
     * Pick a region for a continent from the available regions in that continent
     *
     * @param \Mastercoding\Conquest\Bot\AbstractBot $bot
     * @param \Mastercoding\Conquest\Object\Continent $continent
     * @param $availableRegions
     * @return int
     */
    protected function pickRegionForContinent(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Object\Continent $continent, $availableRegions)
    {
        // pop because shifting is easier
        return array_pop($availableRegions);
    }

    /**
     * Pick additional regions to the already chosen regions
     *
     * @param array $chosenRegions
     * @param array $availableRegionIds
     * @param int $amountToPick
     * @return array
     */
    protected function pickAdditionalRegions($chosenRegions, $availableRegionIds, $amountToPick)
    {
        return array_slice($availableRegionIds, 0, $amountToPick);
    }

    /**
     * @inheritDoc
     */
    public function pickRegions(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand)
    {

        // possible regions
        $regionIds = $pickCommand->getRegionIds();

        // map region ids by continent
        $mappedRegions = array();
        foreach ($regionIds as $regionId) {

            // get region
            $region = $bot->getMap()->getRegionById($regionId);
            $mappedRegions[$region->getContinentId()][] = $regionId;

        }

        // now return as many different as possible
        $chosenRegions = array();
        foreach ($mappedRegions as $continentId => $regions) {

            $region = $this->pickRegionForContinent($bot, $bot->getMap()->getContinentById($continentId), $regions);
            $chosenRegions[] = $region;

            // remove region id from array
            $regionIds = array_diff($regionIds, array($region));

        }

        // add additional
        $amountToPick = 6 - count($chosenRegions);
        if ($amountToPick > 0) {
            $chosenRegions = array_merge($chosenRegions, $this->pickAdditionalRegions($chosenRegions, $regionIds, $amountToPick));
        }

        // return as command
        $pickRegionsMove = new \Mastercoding\Conquest\Move\PickRegions();
        $pickRegionsMove->setRegionIds($chosenRegions);
        return $pickRegionsMove;

    }

}
