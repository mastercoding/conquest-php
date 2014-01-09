<?php

class PathTest extends \PHPUnit_Framework_TestCase
{
    private $map;

    public function setup()
    {

       // bot
        $map = new \Mastercoding\Conquest\Object\Map();
        $eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
        $bot = new \Mastercoding\Conquest\Bot\SimpleBot($map, $eventDispatcher);

        $commandParser = new \Mastercoding\Conquest\Command\Parser\Parser();
        $setupCommands = file(dirname(__FILE__) . '/../setup.txt');

        // process
        foreach ($setupCommands as $line) {
            $command = $commandParser->parse($line);
            $bot->processCommand($command);
        }
        $this->map = $bot->getMap();
    }

    public function testShortestPath()
    {
        $map = $this->map;

        //start/end
        $startRegion = $map->getRegionById(39);
        $endRegion = $map->getRegionById(42);

        // path
        $path = \Mastercoding\Conquest\Bot\Helper\Path::shortestPath($this->map, $startRegion, $endRegion);
        $this->assertCount(3, $path);
        return $path;

    }

    public function testShortestPath2()
    {
        $map = $this->map;

        //start/end
        $startRegion = $map->getRegionById(2);
        $endRegion = $map->getRegionById(42);

        // path
        $path = \Mastercoding\Conquest\Bot\Helper\Path::shortestPath($this->map, $startRegion, $endRegion);
        $this->assertCount(9, $path);
        return $path;

    }

    /**
     * @depends testShortestPath
     */
    public function testPathYours(Array $path)
    {
        // not yours
        $this->assertFalse(\Mastercoding\Conquest\Bot\Helper\Path::pathYours($this->map, $path));

        // yours
        foreach ($path as $region) {
            $region->setOwner($this->map->getYou());
        }

        $this->assertTrue(\Mastercoding\Conquest\Bot\Helper\Path::pathYours($this->map, $path));

    }

}
