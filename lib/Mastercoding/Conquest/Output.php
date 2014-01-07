<?php

namespace Mastercoding\Conquest;

class Output
{

    /**
     * Output moves to standard out
     *
     * @param Array $moves
     */
    public static function moves(Array $moves)
    {
        foreach ($moves as $move) {
            self::move($move);
        }
    }

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