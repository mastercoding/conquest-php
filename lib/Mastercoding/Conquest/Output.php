<?php

namespace Mastercoding\Conquest;

class Output
{

    /**
     * Output a move to standard out
     *
     * @param \Mastercoding\Conquest\Move\MoveInterface $move
     */
    public static function move(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\MoveInterface $move)
    {

        // get you
        $you = $bot->getMap()->getYou();

        // move as string
        $move = $move->toString();

        // replace {{you}} with you
        $move = str_replace('{{you}}', $you->getName(), $move);

        // write to standard out, append newline
        fwrite(STDOUT, $move . "\n");

    }

}