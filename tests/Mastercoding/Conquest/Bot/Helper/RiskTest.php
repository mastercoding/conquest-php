<?php

class RiskTest extends \PHPUnit_Framework_TestCase
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

    public function testGetNamedContinent()
    {

        $map = $this->map;
        $continent = \Mastercoding\Conquest\Bot\Helper\Risk::getNamedContinent($this->map, 'Australia');
        $this->assertEquals(6, $continent->getId());

    }

}
