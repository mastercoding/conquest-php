<?php

namespace Mastercoding\Conquest\Command;

class InfoParser implements \Mastercoding\Conquest\Command\Parser\ParserInterface
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

            case 'region':
                return Info\Region::create($components);
            case 'starting_armies':
                return Info\StartingArmies::create($components);
            case 'round':
                return Info\Round::create($components);
            default:
                throw new \Exception('Unimplemented info: ' . $components[1]);
        }

    }

}
