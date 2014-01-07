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
        $this->map = new \Mastercoding\Conquest\Object\Map;
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
    public function processCommand(\Mastercoding\Conquest\Command\AbstractCommand $command = null)
    {

        // any?
        if (null === $command) {
            return null;
        }

        // process command
        switch ( $command->getName() ) {

            case 'Settings\Player':
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->addPlayer($this->getMap(), $command);
                break;

            case 'Settings\StartingArmies':
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->updateStartingArmies($this->getMap(), $command);
                break;

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

            case 'StartingRegions\Pick':
                return $this->pickRegions($command);

            case 'Go\PlaceArmies':
                return $this->placeArmies($command);

            case 'Go\AttackTransfer':
                return $this->attackTransfer($command);
        }

    }

}
