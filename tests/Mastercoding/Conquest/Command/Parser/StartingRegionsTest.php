<?php

class StartingRegionsTest extends \PHPUnit_Framework_TestCase
{

    public function testPick()
    {

        // the parser
        $inputParser = new \Mastercoding\Conquest\Command\Parser\Parser;

        // bot test
        $command = $inputParser->parse('pick_starting_regions 2000 1 7 12 13 18 15 24');
        $this->assertInstanceOf('\Mastercoding\Conquest\Command\StartingRegions\Pick', $command);

        // timeout
        $this->assertEquals('2000', $command->getTimeout());

        // region ids
        $this->assertEquals(array(1, 7, 12, 13, 18, 15, 24), $command->getRegionIds());

    }

}