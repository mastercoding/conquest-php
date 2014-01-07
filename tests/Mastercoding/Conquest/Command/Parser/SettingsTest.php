<?php

class SettingsTest extends \PHPUnit_Framework_TestCase
{

    public function testYourBot()
    {

        // the parser
        $inputParser = new \Mastercoding\Conquest\Command\Parser\Parser;

        // bot test
        $command = $inputParser->parse('settings your_bot bot1');
        $this->assertInstanceOf('\Mastercoding\Conquest\Command\Settings\Player', $command);

        // name
        $this->assertEquals('bot1', $command->getPlayer()->getName());

        // who
        $this->assertEquals('your_bot', $command->getPlayer()->getWho());

    }

    public function testOpponentBot()
    {

        // the parser
        $inputParser = new \Mastercoding\Conquest\Command\Parser\Parser;

        // bot test
        $command = $inputParser->parse('settings opponent_bot bot2');
        $this->assertInstanceOf('\Mastercoding\Conquest\Command\Settings\Player', $command);

        // name
        $this->assertEquals('bot2', $command->getPlayer()->getName());
        $this->assertEquals('opponent_bot', $command->getPlayer()->getWho());

    }

    public function testStartingArmies()
    {

        // the parser
        $inputParser = new \Mastercoding\Conquest\Command\Parser\Parser;

        // bot test
        $command = $inputParser->parse('settings starting_armies 25');
        $this->assertInstanceOf('\Mastercoding\Conquest\Command\Settings\StartingArmies', $command);

        // name
        $this->assertEquals(25, $command->getAmount());

    }

}
