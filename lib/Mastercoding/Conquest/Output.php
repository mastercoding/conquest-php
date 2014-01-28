<?php

namespace Mastercoding\Conquest;

class Output
{

    /**
     * Output a move to standard out
     *
     * @param \Mastercoding\Conquest\Move\MoveInterface $move
     * @parram $outputHandle
     */
    public static function move(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\MoveInterface $move, $outputHandle)
    {

        // move as string
        $move = $move->toString();

        // write to standard out, append newline
        fwrite($outputHandle, $move . "\n");

    }

}
