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
     * Command history, keep last 10
     *
     * @var Array
     */
    private $commands = array();

    /**
     * Move history, keep last 10
     *
     * @var Array
     */
    private $moves = array();

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

        $this->commands = array();
        $this->moves = array();
    }

    /**
     * Get last command of specific type
     *
     * @return \Mastercoding\Conquest\Command\AbstractCommand|null
     */
    public function getLastCommand($commandName)
    {
        if (isset($this->commands[$commandName])) {
            $count = count($this->commands[$commandName]);
            return $this->commands[$commandName][$count - 1];
        }
        return null;
    }

    /**
     * Get commands of specific type
     *
     * @return array
     */
    public function getCommands($commandName)
    {
        if (isset($this->commands[$commandName])) {
            return $this->commands[$commandName];
        }
        return null;
    }

    /**

     /**
     * Get moves of specific type
     *
     * @return array
     */
    public function getMoves($moveName)
    {
        if (isset($this->moves[$moveName])) {
            return $this->moves[$moveName];
        }
        return null;
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

        // store last command
        $this->commands[$command->getName()][] = $command;
        if (count($this->commands[$command->getName()]) > 10) {
            array_shift($this->commands[$command->getName()]);
        }

        // process command
        switch ( $command->getName() ) {

            case 'Info\Region' :
                $move = new \Mastercoding\Conquest\Move\Info;
                $region = $this->getMap()->getRegionById($command->getRegionId());
                $info = 'Region ' . $command->getRegionId() . ': ' . $region->getArmies() . ' for ' . $region->getOwner()->getName();
                $move->setInfo($info);
                break;

            case 'Info\StartingArmies' :
                $move = new \Mastercoding\Conquest\Move\Info;
                $move->setInfo('Starting armies: ' . $this->getMap()->getStartingArmies());
                break;

            case 'Info\Round' :
                $move = new \Mastercoding\Conquest\Move\Info;
                $move->setInfo('Round nr: ' . $this->getMap()->getRound());
                break;

            case 'Settings\Player' :
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->addPlayer($this->getMap(), $command);
                return;

            case 'Settings\StartingArmies' :
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->updateStartingArmies($this->getMap(), $command);
                return;

            case 'SetupMap\Continents' :
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->setupContinents($this->getMap(), $command);
                return;

            case 'SetupMap\Regions' :
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->setupRegions($this->getMap(), $command);
                return;

            case 'SetupMap\Neighbors' :
                $this->getEventDispatcher()->dispatch(\Mastercoding\Conquest\Event::BEFORE_SETUP_NEIGHBORS);

                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->setupNeighbors($this->getMap(), $command);

                $this->getEventDispatcher()->dispatch(\Mastercoding\Conquest\Event::AFTER_SETUP_NEIGHBORS);
                $this->getEventDispatcher()->dispatch(\Mastercoding\Conquest\Event::SETUP_MAP_COMPLETE);
                return;

            case 'UpdateMap\Update' :
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->updateMap($this->getMap(), $command);
                $this->getEventDispatcher()->dispatch(\Mastercoding\Conquest\Event::AFTER_UPDATE_MAP);
                return;

            case 'OpponentMoves\Moves' :
                $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                $mapUpdater->uppateOpponentMoves($this->getMap(), $command, $this->getLastCommand('UpdateMap\Update'));
                $this->getEventDispatcher()->dispatch(\Mastercoding\Conquest\Event::AFTER_UPDATE_OPPONENT_MOVES);
                return;

            case 'StartingRegions\Pick' :
                $move = $this->pickRegions($command);
                break;

            case 'Go\PlaceArmies' :

                // new round
                $this->getMap()->increaseRound();
                $move = $this->placeArmies($command);

                // update in map
                if ($move instanceof \Mastercoding\Conquest\Move\PlaceArmies) {
                    $mapUpdater = new \Mastercoding\Conquest\MapUpdater;
                    $mapUpdater->updatePlaceArmies($this->getMap(), $move);
                }
                break;

            case 'Go\AttackTransfer' :
                $move = $this->attackTransfer($command);
                break;
        }

        // store
        $this->moves[$move->getName()][] = $move;
        if (count($this->moves[$move->getName()]) > 10) {
            array_shift($this->moves[$move->getName()]);
        }
        return $move;

    }

    /**
     * Run this bot, input from input handle, output to output handle
     *
     * @param $inputHandle
     * @param $outputHandle
     */
    public function run($commandParser, $inputHandle, $outputHandle)
    {

        // loop
        while ($line = fgets($inputHandle)) {

            // trim
            $line = trim($line);

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
