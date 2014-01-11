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
     * The event dispatcher
     *
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    private $eventDispatcher;

    /**
     * Construct the bot
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $eventDispatcher
     */
    public function __construct($map, $eventDispatcher)
    {
        $this->map = $map;
        $this->eventDispatcher = $eventDispatcher;
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
     * Get the event dispatcher
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
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

            case 'Info\Region' :
                $move = new \Mastercoding\Conquest\Move\Info;
                $region = $this->getMap()->getRegionById($command->getRegionId());
                $info = 'Region ' . $command->getRegionId() . ': ' . $region->getArmies() . ' for ' . $region->getOwner()->getName();
                $move->setInfo($info);
                return $move;

            case 'Settings\Player' :
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->addPlayer($this->getMap(), $command);
                break;

            case 'Settings\StartingArmies' :
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->updateStartingArmies($this->getMap(), $command);
                break;

            case 'SetupMap\Continents' :
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->setupContinents($this->getMap(), $command);
                break;

            case 'SetupMap\Regions' :
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->setupRegions($this->getMap(), $command);
                break;

            case 'SetupMap\Neighbors' :
                $this->getEventDispatcher()->dispatch(\Mastercoding\Conquest\Event::BEFORE_SETUP_NEIGHBORS);

                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->setupNeighbors($this->getMap(), $command);

                $this->getEventDispatcher()->dispatch(\Mastercoding\Conquest\Event::AFTER_SETUP_NEIGHBORS);
                $this->getEventDispatcher()->dispatch(\Mastercoding\Conquest\Event::SETUP_MAP_COMPLETE);
                break;

            case 'UpdateMap\Update' :
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->updateMap($this->getMap(), $command);

                $this->getEventDispatcher()->dispatch(\Mastercoding\Conquest\Event::AFTER_UPDATE_MAP);

                break;

            case 'StartingRegions\Pick' :
                return $this->pickRegions($command);

            case 'Go\PlaceArmies' :
                $placeArmiesMove = $this->placeArmies($command);
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->updatePlaceArmies($this->getMap(), $placeArmiesMove);
                return $placeArmiesMove;

            case 'Go\AttackTransfer' :
                return $this->attackTransfer($command);
        }

    }

    /**
     * Run this bot, input from input handle, output to output handle
     *
     * @param $inputHandle
     * @param $outputHandle
     */
    public function run($inputHandle, $outputHandle)
    {

        // setup parser
        $commandParser = new \Mastercoding\Conquest\Command\Parser\Parser();

        // loop
        while ($line = trim(fgets($inputHandle))) {

            // parse command
            $command = $commandParser->parse($line);
            $move = $this->processCommand($command);

            if (null !== $move) {

                // output moves
                \Mastercoding\Conquest\Output::move($this, $move, $outputHandle);

            }

        }

    }

}
