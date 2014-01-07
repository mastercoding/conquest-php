<?php

namespace Mastercoding\Conquest\Bot;

interface BotInterface
{
    /**
     * Process the incomming command
     *
     * @param \Mastercoding\Conquest\Command\AbstractCommand $command
     */
    public function processCommand(\Mastercoding\Conquest\Command\AbstractCommand $command);

    /**
     * Get the place armies response
     *
     * @param \Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand
     * @return \Mastercoding\Conquest\Move\PlaceArmies
     */
    public function placeArmies(\Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand);

    /**
     * Get the pick regions response
     *
     * @param \Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand
     * @return
     * \Mastercoding\Conquest\Move\PickRegions|\Mastercoding\Conquest\Move\PickRandomRegions
     */
    public function pickRegions(\Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand);

    /**
     * Get attack/transfer moves
     *
     * @param \Mastercoding\Conquest\Command\Go\AttackTransfer
     * $attackTransferCommand
     * @return
     * \Mastercoding\Conquest\Move\PickRegions|\Mastercoding\Conquest\Move\PickRandomRegions
     */
    public function attackTransfer(\Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand);

}