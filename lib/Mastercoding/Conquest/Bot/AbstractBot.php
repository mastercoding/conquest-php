<?php

namespace Mastercoding\Conquest\Bot;

abstract class AbstractBot implements BotInterface
{

    /**
     * The map this bot is playing on
     *
     * @var \Mastercoding\Conquest\Object\Map
     */
    private $map;

    /**
     * Construct the bot
     */
    public function __construct()
    {
    }

    /**
     * Set map this bot is playing on
     *
     * @var \Mastercoding\Conquest\Object\Map $map
     */
    public function setMap(\Mastercoding\Conquest\Object\Map $map)
    {
        $this->map = $map;
        return $this;
    }

    /**
     * Get map this bot is playing on
     *
     * @return Map
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @inheritDoc
     */
    public function processCommand(\Mastercoding\Conquest\Command $command)
    {

        // process command
        switch ( $command->getName() ) {

            case 'SetupMap\Continents':
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->setupContinents($this->getMap(), $command);
                break;

            case 'SetupMap\Regions':
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->setupRegions($this->getMap(), $command);
                break;

            case 'SetupMap\Neighbors':
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->setupNeighbors($this->getMap(), $command);
                break;

            case 'UpdateMap\Update':
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->updateMap($this->getMap(), $command);
                break;
        }

    }

    /**
     * @inheritDoc
     */
    public function getMoves()
    {
        return array(new \Mastercoding\Conquest\Move\NoMoves());
    }

}