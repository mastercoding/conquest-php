<?php

namespace Mastercoding\Conquest\Bot\Strategy\AttackTransfer;

interface AttackTransferInterface
{

    /**
     * Generate attack moves
     *
     * @param \Mastercoding\Conquest\Bot\AbstractBot $bot
     * @param \Mastercoding\Conquest\Move\AttackTransfer $move
     * @param \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand
     * @return
     * \Mastercoding\Conquest\Move\NoMove|\Mastercoding\Conquest\Move\AttackTransfer
     */
    public function attack(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\AttackTransfer $move, \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand);

    /**
     * Generate transfer moves
     *
     * @param \Mastercoding\Conquest\Bot\AbstractBot $bot
     * @param \Mastercoding\Conquest\Move\AttackTransfer $move
     * @param \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand
     * @return
     * \Mastercoding\Conquest\Move\NoMove|\Mastercoding\Conquest\Move\AttackTransfer
     */
    public function transfer(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\AttackTransfer $move, \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand);

}