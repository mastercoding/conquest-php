<?php

class StrategicBotTest extends \PHPUnit_Framework_TestCase
{

    public function setup()
    {
        $this->commandParser = new \Mastercoding\Conquest\Command\Parser\Parser();
    }

    /**
     * Setup test
     */
    public function testSetup()
    {

        // bot
        $bot = new \Mastercoding\Conquest\Bot\StrategicBot;
        
        // conquer australia, conquer south america
        $bot->addRegionPickerStrategy(new \Mastercoding\Conquest\Bot\Strategy\RegionPicker\Spread());
        $bot->addAttackTransferStrategy(new \Mastercoding\Conquest\Bot\Strategy\AttackTransfer\NoMoves());
        $bot->addArmyPlacementStrategy(new \Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\AllOnOne());

        // read setup commands
        $setupCommands = file(dirname(__FILE__) . '/setup.txt');

        // process
        foreach ($setupCommands as $line) {

            // parse command
            $command = $this->commandParser->parse($line);
            $bot->processCommand($command);

        }

        // validate continents, regions
        $this->assertCount(6, $bot->getMap()->getContinents());

        // does not exist
        $this->assertNull($bot->getMap()->getRegionById(99));

        // exists
        $this->assertNotNull($bot->getMap()->getRegionById(42));

        // neighbors
        $this->assertCount(3, $bot->getMap()->getRegionById(1)->getNeighbors());

        return $bot;
    }

}
