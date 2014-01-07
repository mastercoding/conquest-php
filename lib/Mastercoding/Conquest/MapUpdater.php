<?php

namespace Mastercoding\Conquest;

/**
 * Map updater updates the map object by processing a UpdateMap\Update command
 */
class MapUpdater
{

    /**
     * Setup continents for the map
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Mastercoding\Conquest\Command\SetupMap\Continents
     * $continentsCommand
     *
     */
    public function setupContinents(\Mastercoding\Conquest\Object\Map $map, \Mastercoding\Conquest\Command\SetupMap\Continents $continentsCommand)
    {

        foreach ($continentsCommand->getContinents() as $continent) {
            $map->addContinent($continent);
        }

    }

    /**
     * Setup regions for the map
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Mastercoding\Conquest\Command\SetupMap\Regions
     * $continentsCommand
     *
     */
    public function setupRegions(\Mastercoding\Conquest\Object\Map $map, \Mastercoding\Conquest\Command\SetupMap\Regions $regionsCommand)
    {

        foreach ($regionsCommand->getRegions() as $region) {

            $continent = $map->getContinentById($region->getContinentId());
            $continent->addRegion($region);

        }

    }

    /**
     * Setup neighbors for the map
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Mastercoding\Conquest\Command\SetupMap\Neighbors
     * $continentsCommand
     *
     */
    public function setupNeighbors(\Mastercoding\Conquest\Object\Map $map, \Mastercoding\Conquest\Command\SetupMap\Neighbors $neighborsCommand)
    {

        foreach ($neighborsCommand->getNeighbors() as $regionId => $neighborRegionIds) {

            $baseRegion = $map->getRegionById($regionId);
            foreach ($neighborRegionIds as $neighborRegionId) {

                $neighborRegion = $map->getRegionById($neighborRegionId);
                $baseRegion->addNeighbor($neighborRegion);

            }

        }

    }

    /**
     * Updates the map $map by processing the update map command
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Mastercoding\Conquest\Command\UpdateMap\Update $updateCommand
     */
    public function updateMap(\Mastercoding\Conquest\Object\Map $map, \Mastercoding\Conquest\Command\UpdateMap\Update $updateCommand)
    {

        // loop updates
        foreach ($updateCommand->getUpdates() as $update) {

            // get region by id
            $region = $map->getRegionById($update['regionId']);
            $region->setArmies($update['armies']);

            // owner

        }

    }

}
