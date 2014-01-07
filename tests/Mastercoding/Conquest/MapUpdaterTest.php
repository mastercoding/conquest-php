<?php

class MapUpdaterTest extends \PHPUnit_Framework_TestCase
{

    private $mapUpdater;

    public function setup()
    {
        $this->mapUpdater = new \Mastercoding\Conquest\MapUpdater;
    }

    public function testSetupContinents()
    {

        // map
        $map = new \Mastercoding\Conquest\Object\Map;

        // create continents setup
        $continentsUpdate = new \Mastercoding\Conquest\Command\SetupMap\Continents;

        // add test continents: id, bonus
        $continentsUpdate->addContinent(new \Mastercoding\Conquest\Object\Continent(1, 4));
        $continentsUpdate->addContinent(new \Mastercoding\Conquest\Object\Continent(3, 5));

        // process
        $this->mapUpdater->setupContinents($map, $continentsUpdate);

        // validate
        $this->assertNotNull($map->getContinentById(1));
        $this->assertNotNull($map->getContinentById(3));
        $this->assertNull($map->getContinentById(2));

        // return the map
        return $map;

    }

    /**
     * @depends testSetupContinents
     */
    public function testSetupRegions(\Mastercoding\Conquest\Object\Map $map)
    {

        // create continents setup
        $regionsUpdate = new \Mastercoding\Conquest\Command\SetupMap\Regions;

        // add test continents: id, bonus
        $regionsUpdate->addRegion(new \Mastercoding\Conquest\Object\Region(1, 1));
        $regionsUpdate->addRegion(new \Mastercoding\Conquest\Object\Region(2, 1));
        $regionsUpdate->addRegion(new \Mastercoding\Conquest\Object\Region(3, 1));
        $regionsUpdate->addRegion(new \Mastercoding\Conquest\Object\Region(4, 1));
        $regionsUpdate->addRegion(new \Mastercoding\Conquest\Object\Region(5, 1));
        $regionsUpdate->addRegion(new \Mastercoding\Conquest\Object\Region(6, 3));
        $regionsUpdate->addRegion(new \Mastercoding\Conquest\Object\Region(7, 3));

        // process
        $this->mapUpdater->setupRegions($map, $regionsUpdate);

        // validate
        $this->assertCount(5, $map->getContinentById(1)->getRegions());
        $this->assertCount(2, $map->getContinentById(3)->getRegions());
        return $map;

    }

    /**
     * @depends testSetupRegions
     */
    public function testSetupNeighbors(\Mastercoding\Conquest\Object\Map $map)
    {

        // create continents setup
        $neighborsUpdate = new \Mastercoding\Conquest\Command\SetupMap\Neighbors;

        // add test continents: region id, array neighbor regions
        $neighborsUpdate->setNeighbor(1, array(2, 3));
        $neighborsUpdate->setNeighbor(2, array(4));
        $neighborsUpdate->setNeighbor(3, array(4));
        $neighborsUpdate->setNeighbor(4, array(7));
        $neighborsUpdate->expand();

        // process
        $this->mapUpdater->setupNeighbors($map, $neighborsUpdate);

        // validate
        $this->assertCount(2, $map->getRegionById(1)->getNeighbors());
        $this->assertCount(3, $map->getRegionById(4)->getNeighbors());
        $this->assertCount(1, $map->getRegionById(7)->getNeighbors());

        return $map;

    }

    /**
     * @depends testSetupNeighbors
     */
    public function testSetupPlayers(\Mastercoding\Conquest\Object\Map $map)
    {

        // create continents setup
        $playersUpdate = new \Mastercoding\Conquest\Command\Settings\Player('your_bot', 'player2');
        $this->mapUpdater->addPlayer($map, $playersUpdate);
        $this->assertCount(1, $map->getPlayers());

        $playersUpdate = new \Mastercoding\Conquest\Command\Settings\Player('opponent_bot', 'player1');
        $this->mapUpdater->addPlayer($map, $playersUpdate);
        $this->assertCount(2, $map->getPlayers());

        return $map;

    }

    /**
     * @depends testSetupPlayers
     */
    public function testUpdateMap(\Mastercoding\Conquest\Object\Map $map)
    {

        // create continents setup
        $mapUpdate = new \Mastercoding\Conquest\Command\UpdateMap\Update;

        // add some updates
        $mapUpdate->addUpdate(array('regionId' => 1, 'owner' => 'neutral', 'armies' => 2));
        $mapUpdate->addUpdate(array('regionId' => 2, 'owner' => 'player1', 'armies' => 3));
        $mapUpdate->addUpdate(array('regionId' => 4, 'owner' => 'neutral', 'armies' => 4));
        $mapUpdate->addUpdate(array('regionId' => 7, 'owner' => 'neutral', 'armies' => 5));

        // process
        $this->mapUpdater->updateMap($map, $mapUpdate);

        // assert owners
        $this->assertEquals('neutral', $map->getRegionById(1)->getOwner()->getName());
        $this->assertEquals('player1', $map->getRegionById(2)->getOwner()->getName());
        $this->assertEquals('unknown', $map->getRegionById(3)->getOwner()->getName());

        // asert armies
        $this->assertEquals(4, $map->getRegionById(4)->getArmies());
        $this->assertEquals(2, $map->getRegionById(1)->getArmies());
    }

    public function testStartingArmies()
    {

        // map
        $map = new \Mastercoding\Conquest\Object\Map;

        // command
        $startingArmiesCommand = new \Mastercoding\Conquest\Command\Settings\StartingArmies(4);

        // process
        $this->mapUpdater->updateStartingArmies($map, $startingArmiesCommand);

        // validate
        $this->assertEquals(4, $map->getStartingArmies());

    }

    public function testPlayers()
    {

        // map
        $map = new \Mastercoding\Conquest\Object\Map;

        // command
        $playerCommand = new \Mastercoding\Conquest\Command\Settings\Player('your_bot', 'player1');

        // process
        $this->mapUpdater->addPlayer($map, $playerCommand);

        // validate
        $this->assertCount(1, $map->getPlayers());

        // command
        $playerCommand = new \Mastercoding\Conquest\Command\Settings\Player('opponent_bot', 'player2');

        // process
        $this->mapUpdater->addPlayer($map, $playerCommand);

        // validate
        $this->assertCount(2, $map->getPlayers());

        // you
        $this->assertEquals('player1', $map->getYou()->getName());
    }

}
