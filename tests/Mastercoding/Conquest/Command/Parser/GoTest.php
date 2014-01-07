<?php

class GoTest extends \PHPUnit_Framework_TestCase
{

    public function testPlaceArmies()
    {

        // the parser
        $inputParser = new \Mastercoding\Conquest\Command\Parser\Parser;

        // bot test
        $command = $inputParser->parse('go place_armies 2000');
        $this->assertInstanceOf('\Mastercoding\Conquest\Command\Go\PlaceArmies', $command);

        // timeout
        $this->assertEquals('2000', $command->getTimeout());

    }

    public function testAttackTransfer()
    {

        // the parser
        $inputParser = new \Mastercoding\Conquest\Command\Parser\Parser;

        // bot test
        $command = $inputParser->parse('go attack/transfer 1000');
        $this->assertInstanceOf('\Mastercoding\Conquest\Command\Go\AttackTransfer', $command);

        // timeout
        $this->assertEquals('1000', $command->getTimeout());

    }

}
