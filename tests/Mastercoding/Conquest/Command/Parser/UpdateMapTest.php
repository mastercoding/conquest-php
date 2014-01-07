<?php

class UpdateMapTest extends \PHPUnit_Framework_TestCase
{

    public function testUpdate()
    {

        // the parser
        $inputParser = new \Mastercoding\Conquest\Command\Parser\Parser;

        // bot test
        $command = $inputParser->parse('update_map 13 player1 2 24 player1 2 33 player1 2 11 neutral 4');
        $this->assertInstanceOf('\Mastercoding\Conquest\Command\UpdateMap\Update', $command);

        // timeout
        $updates = array();
        $updates[] = array('regionId' => 13, 'owner' => 'player1', 'armies' => 2);
        $updates[] = array('regionId' => 24, 'owner' => 'player1', 'armies' => 2);
        $updates[] = array('regionId' => 33, 'owner' => 'player1', 'armies' => 2);
        $updates[] = array('regionId' => 11, 'owner' => 'neutral', 'armies' => 4);

        // region ids
        $this->assertEquals($updates, $command->getUpdates());

    }

}