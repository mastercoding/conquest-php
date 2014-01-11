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
        $this->removeRegionPickerStrategy($strategy);
        $this->removeArmyPlacementStrategy($strategy);
        $this->removeAttackTransferStrategy($strategy);
        return $this;
    }

    /**
     * Add a strategy to the bot. The strategy should implement all interfaces:
     * RegionPickerInterface, ArmyPlacementInterface, AttackTransferInterface
     *
     * @param $strategy
     */
    public function addStrategy($strategy)
    {
        $this->addRegionPickerStrategy($strategy);
        $this->addArmyPlacementStrategy($strategy);
        $this->addAttackTransferStrategy($strategy);
        return $this;
    }

    /**
     * Remove the region picker strategy
     *
     * @var
     * \Mastercoding\Conquest\Bot\Strategy\RegionPicker\RegionPickerInterface
     * $regionPickerStrategy
     */
    public function removeRegionPickerStrategy(\Mastercoding\Conquest\Bot\Strategy\RegionPicker\RegionPickerInterface $regionPickerStrategy)
    {
        for ($i = 0; $i < count($this->regionPickerStrategies); $i++) {

            if ($this->regionPickerStrategies[$i] == $regionPickerStrategy) {
                unset($this->regionPickerStrategies[$i]);
            }

        }
        $this->sortStrategies($this->regionPickerStrategies);
        return $this;
    }

    /**
     * Set the region picker strategy
     *
     * @var
     * \Mastercoding\Conquest\Bot\Strategy\RegionPicker\RegionPickerInterface
     * $regionPickerStrategy
     */
    public function addRegionPickerStrategy(\Mastercoding\Conquest\Bot\Strategy\RegionPicker\RegionPickerInterface $regionPickerStrategy)
    {
        $this->regionPickerStrategies[] = $regionPickerStrategy;
        $this->sortStrategies($this->regionPickerStrategies);
        return $this;
    }

    /**
     * Remove the region picker strategy
     *
     * @var
     * \Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\ArmyPlacementInterface
     * $armyPlacementStrategy
     */
    public function removeArmyPlacementStrategy(\Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\ArmyPlacementInterface $armyPlacementStrategy)
    {
        for ($i = 0; $i < count($this->armyPlacementStrategies); $i++) {

            if ($this->armyPlacementStrategies[$i] == $armyPlacementStrategy) {
                unset($this->armyPlacementStrategies[$i]);
            }

        }
        $this->sortStrategies($this->armyPlacementStrategies);
        return $this;
    }

    /**
     * Set the region picker strategy
     *
     * @var\Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\ArmyPlacementInterface
     * $armyPlacementStrategy
     * @var int $priority
     */
    public function addArmyPlacementStrategy(\Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\ArmyPlacementInterface $armyPlacementStrategy)
    {
        $this->armyPlacementStrategies[] = $armyPlacementStrategy;
        $this->sortStrategies($this->armyPlacementStrategies);
        return $this;
    }

    /**
     * Remove attack transfer
     *
     * @var
     * \Mastercoding\Conquest\Bot\Strategy\AttackTransfer\AttackTransferInterface
     * $attackTransferStrategy
     */
    public function removeAttackTransferStrategy(\Mastercoding\Conquest\Bot\Strategy\AttackTransfer\AttackTransferInterface $attackTransferStrategy)
    {
        for ($i = 0; $i < count($this->armyPlacementStrategies); $i++) {

            if ($this->attackTransferStrategies[$i] == $attackTransferStrategy) {
                unset($this->attackTransferStrategies[$i]);
            }

        }
        $this->sortStrategies($this->attackTransferStrategies);
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
        $this->attackTransferStrategies[] = $attackTransferStrategy;
        $this->sortStrategies($this->attackTransferStrategies);
        return $this;
    }

    /**
     * Bot should be notified if strategies priority are changed
     */
    public function strategiesChanged()
    {
        $this->sortStrategies($this->attackTransferStrategies);
        $this->sortStrategies($this->armyPlacementStrategies);
        $this->sortStrategies($this->regionPickerStrategies);
    }

    /**
     * Sort strategies by priority
     *
     * @param Array $strategies
     */
    private function sortStrategies(Array &$strategies)
    {

        usort($strategies, function($a, $b)
        {
            if ($a->getPriority() < $b->getPriority()) {
                return 1;
            } else if ($a->getPriority() > $b->getPriority()) {
                return -1;
            }
            return 0;

        });

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
        $move = new \Mastercoding\Conquest\Move\PlaceArmies;
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

        // move
        $move = $response[0];

        // no move
        if (count($move->getPlaceArmies()) == 0) {
            $move = new \Mastercoding\Conquest\Move\NoMove;
        }
        
        // move
        return $move;

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
        foreach ($this->attackTransferStrategies as $strategy) {

            // move
            $move = $strategy->attackTransfer($this, $move, $attackTransferCommand);

            // no move
            if ($move instanceof \Mastercoding\Conquest\Move\NoMove) {
                break;
            }
        }

        // no moves
        if (count($move->getAttackTransfer()) == 0) {
            $move = new \Mastercoding\Conquest\Move\NoMove;
        }

        // return move
        return $move;
    }

}
