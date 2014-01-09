<?php

namespace Mastercoding\Conquest\Bot;

/**
 * This bot's core functionality is implemented by strategies, which can be
 * swapped at run time in anticipation to opponent moves or map changes (or
 * whatever you want)
 */
class StrategicBot extends AbstractBot
{

    /**
     * A region picker strategy. This strategy is asked to pick the starting
     * regions
     *
     * @var array
     */
    private $regionPickerStrategies;

    /**
     * An army placement strategy. This strategy is asked to place armies at each
     * round
     *
     * @var array
     */
    private $armyPlacementStrategies;

    /**
     * An attack/transfer strategy. This strategy is asked to create
     * attack/transfer moves at each round
     *
     * @var array
     */
    private $attackTransferStrategies;

    /**
     * Constructor
     */
    public function __construct($map, $eventDispatcher)
    {
        // parent
        parent::__construct($map, $eventDispatcher);

        // queues
        $this->regionPickerStrategies = array();
        $this->armyPlacementStrategies = array();
        $this->attackTransferStrategies = array();
    }

    /**
     * Remove a strategy from the bot
     *
     * @param $strategy
     */
    public function removeStrategy($strategy)
    {
        die('todo');
        return $this;
    }

    /**
     * Add a strategy to the bot. The strategy should implement all interfaces:
     * RegionPickerInterface, ArmyPlacementInterface, AttackTransferInterface
     *
     * @param $strategy
     */
    public function addStrategy($strategy, $priority = 0)
    {
        $this->addRegionPickerStrategy($strategy, $priority);
        $this->addArmyPlacementStrategy($strategy, $priority);
        $this->addAttackTransferStrategy($strategy, $priority);
        return $this;
    }

    /**
     * Set the region picker strategy
     *
     * @var
     * \Mastercoding\Conquest\Bot\Strategy\RegionPicker\RegionPickerInterface
     * $regionPickerStrategy
     * @var int $priority
     */
    public function addRegionPickerStrategy(\Mastercoding\Conquest\Bot\Strategy\RegionPicker\RegionPickerInterface $regionPickerStrategy, $priority = 0)
    {
        $this->regionPickerStrategies->insert($regionPickerStrategy, $priority);
        return $this;
    }

    /**
     * Set the region picker strategy
     *
     * @var\Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\ArmyPlacementInterface
     * $armyPlacementStrategy
     * @var int $priority
     */
    public function addArmyPlacementStrategy(\Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\ArmyPlacementInterface $armyPlacementStrategy, $priority = 0)
    {
        $this->armyPlacementStrategies->insert($armyPlacementStrategy, $priority);
        return $this;
    }

    /**
     * Set the region picker strategy
     *
     * @var\Mastercoding\Conquest\Bot\Strategy\AttackTransfer\AttackTransferInterface
     * $attackTransferStrategy
     * @var int $priority
     */
    public function addAttackTransferStrategy(\Mastercoding\Conquest\Bot\Strategy\AttackTransfer\AttackTransferInterface $attackTransferStrategy, $priority = 0)
    {
        $this->attackTransferStrategies->insert($attackTransferStrategy, $priority);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function pickRegions(\Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand)
    {

        // move, move and amount left
        $move = new \Mastercoding\Conquest\Move\PickRegions;
        $move->setPlayerName($this->getMap()->getYou()->getName());

        // the response
        $response = array($move, 6);

        // only one region picker can pick
        foreach ($this->regionPickerStrategies as $strategy) {
            $response = $strategy->pickRegions($this, $response[0], $response[1], $pickCommand);
            if ($response[1] == 0) {
                break;
            }
        }

        // return move
        return $response[0];

    }

    /**
     * @inheritDoc
     */
    public function placeArmies(\Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand)
    {

        // armies to place
        $armiesToPlace = $this->getMap()->getStartingArmies();

        // move, move and amount left
        $move = new \Mastercoding\Conquest\Move\AttackTransfer;
        $move->setPlayerName($this->getMap()->getYou()->getName());

        // the response
        $response = array($move, $armiesToPlace);

        // only one region picker can pick
        foreach ($this->armyPlacementStrategies as $strategy) {
            $response = $strategy->placeArmies($this, $response[0], $response[1], $placeArmiesCommand);
            if ($response[1] == 0) {
                break;
            }
        }

        // return move
        return $response[0];

    }

    /**
     * @inheritDoc
     */
    public function attackTransfer(\Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand)
    {

        // move, move and amount left
        $move = new \Mastercoding\Conquest\Move\AttackTransfer;
        $move->setPlayerName($this->getMap()->getYou()->getName());

        // only one region picker can pick
        foreach ($this->regionPickerStrategies as $strategy) {
            $move = $strategy->placeArmies($this, $move, $placeArmiesCommand);
        }

        // return move
        return $move;
    }

}
