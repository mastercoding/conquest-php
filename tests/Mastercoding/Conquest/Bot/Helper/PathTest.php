<?php

class PathTest extends \PHPUnit_Framework_TestCase
{
    private $commandParser;
    private $bot;

    public function setup()
    {

        // bot
        $map = new \Mastercoding\Conquest\Object\Map();
        $eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
        $this->bot = new \Mastercoding\Conquest\Bot\SimpleBot($map, $eventDispatcher);

        $this->commandParser = new \Mastercoding\Conquest\Command\Parser\Parser();
        $setupCommands = file(dirname(__FILE__) . '/../setup.txt');

        // process
        foreach ($setupCommands as $line) {
            $command = $this->commandParser->parse($line);
            $this->bot->processCommand($command);
        }

    }

    public function testShortestPath()
    {
        $map = $this->bot->getMap();

        //start/end
        $startRegion = $map->getRegionById(39);
        $endRegion = $map->getRegionById(42);

        // path
        $path = \Mastercoding\Conquest\Bot\Helper\Path::shortestPath($map, $startRegion, $endRegion);
        $this->assertCount(3, $path);
        return $path;

    }

    public function testShortestPath2()
    {
        $map = $this->bot->getMap();

        //start/end
        $startRegion = $map->getRegionById(2);
        $endRegion = $map->getRegionById(42);

        // path
        $path = \Mastercoding\Conquest\Bot\Helper\Path::shortestPath($map, $startRegion, $endRegion);
        $this->assertCount(9, $path);
        return $path;

    }

    public function testMyPath()
    {
        // process
        $setupCommands = array('update_map 39 player1 2 40 player1 2 42 player1 2');
        foreach ($setupCommands as $line) {
            $command = $this->commandParser->parse($line);
            $this->bot->processCommand($command);
        }

        // map
        $map = $this->bot->getMap();

        //start/end
        $startRegion = $map->getRegionById(39);
        $endRegion = $map->getRegionById(42);

        // path
        $path = \Mastercoding\Conquest\Bot\Helper\Path::shortestPath($map, $startRegion, $endRegion, true);
        $this->assertCount(3, $path);
        return $path;

    }

    /**
     * @depends testShortestPath
     */
    public function testPathYours(Array $path)
    {
        // not yours
        $map = $this->bot->getMap();
        $this->assertFalse(\Mastercoding\Conquest\Bot\Helper\Path::pathYours($map, $path));

        // yours
        foreach ($path as $region) {
            $region->setOwner($map->getYou());
        }

        $this->assertTrue(\Mastercoding\Conquest\Bot\Helper\Path::pathYours($map, $path));

    }

    public function testUnwalkablePath()
    {

        // unwalkable
        $unwalkable = 'update_map 1 player1 2 2 player1 2 3 player1 2 4 player1 2 5 neutral 2 6 neutral 2 7 neutral 2 8 neutral 2 9 player1 2';
        $command = $this->commandParser->parse($unwalkable);
        $this->bot->processCommand($command);
        
        // path is unwalkable: region 1 to 9
        $regionFrom = $this->bot->getMap()->getRegionById(1);
        $regionTo = $this->bot->getMap()->getRegionById(9);
        
        // no path that is mine
        $this->assertNull(\Mastercoding\Conquest\Bot\Helper\Path::shortestPath($this->bot->getMap(), $regionFrom, $regionTo, true));
        
    }

}
