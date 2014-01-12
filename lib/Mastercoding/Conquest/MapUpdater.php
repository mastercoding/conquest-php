<?php

namespace Mastercoding\Conquest;

/**
 * Map updater updates the map object by processing a UpdateMap\Update command
 */
class MapUpdater
{

    /**
     * Settings, add player
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Mastercoding\Conquest\Command\Settings\Player
     * $continentsCommand
     *
     */
    public function addPlayer(\Mastercoding\Conquest\Object\Map $map, \Mastercoding\Conquest\Command\Settings\Player $playerCommand)
    {
        $map->addPlayer($playerCommand->getPlayer());
    }

    /**
     * Settings, starting armies
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Mastercoding\Conquest\Command\Settings\Player
     * $continentsCommand
     *
     */
    public function updateStartingArmies(\Mastercoding\Conquest\Object\Map $map, \Mastercoding\Conquest\Command\Settings\StartingArmies $startingArmiesCommand)
    {
        $map->setStartingArmies($startingArmiesCommand->getAmount());
    }

    /**
     * Settings, starting armies
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Mastercoding\Conquest\Command\Settings\Player
     * $continentsCommand
     *
     */
    public function updatePlaceArmies(\Mastercoding\Conquest\Object\Map $map, \Mastercoding\Conquest\Move\PlaceArmies $placeArmiesMove)
    {

        // update map with armies
        foreach ($placeArmiesMove->getPlaceArmies() as $regionId => $armies) {
            $map->getRegionById($regionId)->addArmies($armies);
        }

    }

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
     * Updates the map $map by processing the opponents moves. We only need to do
     * this for regions not present in lasts update map command
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Mastercoding\Conquest\Command\OpponentMoves\Moves $movesCommand
     * @param \Mastercoding\Conquest\Command\UpdateMap\Update $lastUpdateCommand
     */
    public function uppateOpponentMoves(\Mastercoding\Conquest\Object\Map $map, \Mastercoding\Conquest\Command\OpponentMoves\Moves $movesCommand, \Mastercoding\Conquest\Command\UpdateMap\Update $lastUpdateCommand)
    {

        // regions not present in last update
        $moves = new \SplObjectStorage;
        foreach ($movesCommand->getMoves() as $move) {

            // only attack/transfer
            if ($move instanceof \Mastercoding\Conquest\Move\AttackTransfer) {

                // attack transfer
                $attackTransfer = $move->getAttackTransfer();
                $regionId = $attackTransfer[0]['regionToId'];

                // ok
                foreach ($lastUpdateCommand->getUpdates() as $update) {

                    if ($update['regionId'] == $regionId) {
                        continue 2;
                    }

                }

                // not same
                $moves->attach($move);

            }

        }
        
        
        // ok, create update map command
        $updateMap = new \Mastercoding\Conquest\Command\UpdateMap\Update;
        foreach ($moves as $move) {

            foreach ($move->getAttackTransfer() as $attackTransfer) {
                
                $regionId = $attackTransfer['regionToId'];
                $owner = $move->getPlayerName();
                $armies = $attackTransfer['armies'];

                // add update
                $updateMap->addUpdate(array('regionId' => $regionId, 'owner' => $owner, 'armies' => $armies));

            }

        }
        
        // update
        $this->updateMap($map, $updateMap);

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
            if ($update['owner'] == 'neutral') {
                $region->setOwner(new \Mastercoding\Conquest\Object\Owner\Neutral);
            } else {

                foreach ($map->getPlayers() as $player) {
                    if ($player->getName() == $update['owner']) {
                        $region->setOwner($player);
                    }
                }

            }

        }

    }

}
