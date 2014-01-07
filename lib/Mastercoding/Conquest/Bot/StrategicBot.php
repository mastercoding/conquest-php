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
     * @var
     * \Mastercoding\Conquest\Bot\Strategy\RegionPicker\RegionPickerInterface
     */
    private $regionPickerStrategy;

    /**
     * An army placement strategy. This strategy is asked to place armies at each
     * round
     *
     * @var
     * \Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\ArmyPlacementInterface
     */
    private $armyPlacementStrategy;

    /**
     * An attack/transfer strategy. This strategy is asked to create
     * attack/transfer moves at each round
     *
     * @var
     * \Mastercoding\Conquest\Bot\Strategy\AttackTransfer\AttackTransferInterface
     */
    private $attackTransferStrategy;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set the region picker strategy
     *
     * @var\Mastercoding\Conquest\Bot\Strategy\RegionPicker\RegionPickerInterface
     * $regionPickerStrategy
     */
    public function setRegionPickerStrategy(\Mastercoding\Conquest\Bot\Strategy\RegionPicker\RegionPickerInterface $regionPickerStrategy)
    {
        $this->regionPickerStrategy = $regionPickerStrategy;
        return $this;
    }

    /**
     * Set the region picker strategy
     *
     * @var\Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\ArmyPlacementInterface
     * $armyPlacementStrategy
     */
    public function setArmyPlacementStrategy(\Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\ArmyPlacementInterface $armyPlacementStrategy)
    {
        $this->armyPlacementStrategy = $armyPlacementStrategy;
        return $this;
    }

    /**
     * Set the region picker strategy
     *
     * @var\Mastercoding\Conquest\Bot\Strategy\AttackTransfer\AttackTransferInterface
     * $attackTransferStrategy
     */
    public function setAttackTransferStrategy(\Mastercoding\Conquest\Bot\Strategy\AttackTransfer\AttackTransferInterface $attackTransferStrategy)
    {
        $this->attackTransferStrategy = $attackTransferStrategy;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function pickRegions(\Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand)
    {
        return $this->regionPickerStrategy->pickRegions($this, $pickCommand);
    }

    /**
     * @inheritDoc
     */
    public function placeArmies(\Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand)
    {
        return $this->armyPlacementStrategy->placeArmies($this, $placeArmiesCommand);
    }

    /**
     * @inheritDoc
     */
    public function attackTransfer(\Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand)
    {
        return $this->attackTransferStrategy->attackTransfer($this, $attackTransferCommand);
    }

}