<?php

namespace Mastercoding\Conquest\Bot\Strategy\AttackTransfer;

interface AttackTransferInterface
{

    /**
     * Generate attack transfer moves
     *
     * @param \Mastercoding\Conquest\Bot\AbstractBot $bot
     * @param \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand
     * @return
     * \Mastercoding\Conquest\Move\NoMove|\Mastercoding\Conquest\Move\AttackTransfer
     */
    public function attackTransfer(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand);

}