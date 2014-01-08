<?php

class GeneralTest extends \PHPUnit_Framework_TestCase
{
    private $map;

    public function setup()
    {
        $commandParser = new \Mastercoding\Conquest\Command\Parser\Parser();
        $bot = new \Mastercoding\Conquest\Bot\SimpleBot;
        $setupCommands = file(dirname(__FILE__) . '/../setup.txt');

        // process
        foreach ($setupCommands as $line) {
            $command = $commandParser->parse($line);
            $bot->processCommand($command);
        }
        $this->map = $bot->getMap();
    }

    public function testNotCaptured()
    {

        // australia
        $australia = $this->map->getContinentById(6);

        // not captured
        $this->assertFalse(\Mastercoding\Conquest\Bot\Helper\General::continentCaptured($this->map, $australia));

    }

    public function testCaptured()
    {

        // australia
        $australia = $this->map->getContinentById(6);

        // catpure
        foreach ($australia->getRegions() as $region) {
            $region->setOwner($this->map->getYou());
        }

        // captured
        $this->assertTrue(\Mastercoding\Conquest\Bot\Helper\General::continentCaptured($this->map, $australia));

    }

}
