<?php

namespace Mastercoding\Conquest\Bot\Strategy\AttackTransfer;

class NoMoves implements AttackTransferInterface
{

    /**
     * @inheritDoc
     */
    public function attackTransfer(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\AttackTransfer $move, \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand)
    {
        return new \Mastercoding\Conquest\Move\NoMove();
    }

}