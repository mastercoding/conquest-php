<?php

class SetupMapTest extends \PHPUnit_Framework_TestCase
{

    public function testContinents()
    {

        // the parser
        $inputParser = new \Mastercoding\Conquest\Command\Parser\Parser;

        // bot test
        $command = $inputParser->parse('setup_map super_regions 1 2 2 5');
        $this->assertInstanceOf('\Mastercoding\Conquest\Command\SetupMap\Continents', $command);

        // make sure continents are present
        $this->assertEquals(2, count($command->getContinents()));

        // loop
        $ids = array(1, 2);
        $bonuses = array(2, 5);

        $i = 0;
        foreach ($command->getContinents() as $continent) {

            $this->assertEquals($ids[$i], $continent->getId());
            $this->assertEquals($bonuses[$i], $continent->getBonus());
            $i++;

        }

    }

    public function testRegions()
    {

        // the parser
        $inputParser = new \Mastercoding\Conquest\Command\Parser\Parser;

        // bot test
        $command = $inputParser->parse('setup_map regions 1 1 2 1 3 2 4 2 5 2');
        $this->assertInstanceOf('\Mastercoding\Conquest\Command\SetupMap\Regions', $command);

        // make sure continents are present
        $this->assertEquals(5, count($command->getRegions()));

        // loop
        $ids = array(1, 2, 3, 4, 5);
        $continents = array(1, 1, 2, 2, 2);

        $i = 0;
        foreach ($command->getRegions() as $region) {

            $this->assertEquals($ids[$i], $region->getId());
            $this->assertEquals($continents[$i], $region->getContinentId());
            $i++;

        }

    }

    public function testNeighbors()
    {

        // the parser
        $inputParser = new \Mastercoding\Conquest\Command\Parser\Parser;

        // bot test
        $command = $inputParser->parse('setup_map neighbors 1 2,3,4 2 3 4 5');
        $this->assertInstanceOf('\Mastercoding\Conquest\Command\SetupMap\Neighbors', $command);

        // region connections
        $regions = array(1 => array(2, 3, 4), 2 => array(1, 3), 3 => array(1, 2), 4 => array(1, 5), 5 => array(4));

        $neighbors = $command->getNeighbors();
        foreach ($regions as $regionId => $neighborIds) {

            $this->assertEquals(count($neighborIds), count($neighbors[$regionId]));
            $this->assertEquals($neighborIds, $neighbors[$regionId]);
        }

    }

}
