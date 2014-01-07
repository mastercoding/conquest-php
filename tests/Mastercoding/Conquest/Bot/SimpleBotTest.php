<?php

class SimpleBotTest extends \PHPUnit_Framework_TestCase
{

    private $simpleBot;
    private $commandParser;

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
        $bot = new \Mastercoding\Conquest\Bot\SimpleBot;

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

    /**
     * @depends testSetup
     */
    public function testPickStartingRegions(\Mastercoding\Conquest\Bot\SimpleBot $bot)
    {

        // line in
        $line = 'pick_starting_regions 2000 1 7 10 13 17 15 24 21 36 30 41 39';

        // parse command
        $command = $this->commandParser->parse($line);
        $move = $bot->processCommand($command);

        // should be a random regions move
        $this->assertInstanceOf('\\Mastercoding\\Conquest\\Move\\PickRandomRegions', $move);

        // bot
        return $bot;

    }

    /**
     * @depends testPickStartingRegions
     */
    public function testUpdateMap(\Mastercoding\Conquest\Bot\SimpleBot $bot)
    {

        // line in
        $line = 'update_map 13 player2 2 17 player2 2 36 player2 2 11 neutral 2 12 neutral 2 16 neutral 2 19 neutral 2 20 neutral 2 27 neutral 2 32 neutral 2 22 neutral 2 23 neutral 2 37 neutral 2';

        // parse command
        $command = $this->commandParser->parse($line);
        $bot->processCommand($command);

        return $bot;

    }

    /**
     * @depends testUpdateMap
     */
    public function testOpponentMoves(\Mastercoding\Conquest\Bot\SimpleBot $bot)
    {

        // line in
        $line = 'opponent_moves blabla';

        // parse command
        $command = $this->commandParser->parse($line);
        $bot->processCommand($command);

        return $bot;

    }

    /**
     * @depends testOpponentMoves
     */
    public function testPlaceArmies(\Mastercoding\Conquest\Bot\SimpleBot $bot)
    {

        // line in
        $line = 'go place_armies 2000';

        // parse command
        $command = $this->commandParser->parse($line);
        $move = $bot->processCommand($command);

        // should be a place armies
        $this->assertInstanceOf('\\Mastercoding\\Conquest\\Move\\PlaceArmies', $move);
        return $bot;

    }

}
