<?php

namespace Mastercoding\Conquest\Command;

class GoParser implements \Mastercoding\Conquest\Command\Parser\ParserInterface
{

    /**
     * @inheritDoc
     */
    public function parse($line)
    {

        // seperate components
        $components = explode(' ', $line);

        // parse setting name into input command
        switch ( $components[1] ) {

            case 'place_armies':
                return Go\PlaceArmies::create($components);
            case 'attack/transfer':
                return Go\AttackTransfer::create($components);
            default:
                throw new \Exception('Unimplemented go: ' . $components[1]);
        }

    }

}
