<?php

namespace Mastercoding\Conquest;

class Output
{

    /**
     * Output a move to standard out
     *
     * @param \Mastercoding\Conquest\Move\MoveInterface $move
     */
    public static function move(\Mastercoding\Conquest\Move\MoveInterface $move)
    {

        // write to standard out, append newline
        fwrite(STDOUT, $move->toString() . "\n");

    }

}