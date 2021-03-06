<?php

namespace Mastercoding\Conquest\Bot\Strategy\AttackTransfer;

class NoMoves extends \Mastercoding\Conquest\Bot\Strategy\AbstractStrategy implements AttackTransferInterface
{

    /**
     * @inheritDoc
     */
    public function attack(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\AttackTransfer $move, \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand)
    {
        return new \Mastercoding\Conquest\Move\NoMove();
    }

    /**
     * @inheritDoc
     */
    public function transfer(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\AttackTransfer $move, \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand)
    {
        return new \Mastercoding\Conquest\Move\NoMove();
    }

}