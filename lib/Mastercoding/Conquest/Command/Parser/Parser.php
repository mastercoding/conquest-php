<?php

namespace Mastercoding\Conquest\Command\Parser;

class Parser implements ParserInterface
{

    /**
     * @inheritDoc
     */
    public function parse($line)
    {

        // seperate components
        $line = trim($line);
        $components = explode(' ', $line);

        // designator
        switch ( $components[0] ) {

            case 'settings':
                return \Mastercoding\Conquest\Command\SettingParser::parse($line);
            case 'setup_map':
                return \Mastercoding\Conquest\Command\SetupMapParser::parse($line);
            case 'go':
                return \Mastercoding\Conquest\Command\GoParser::parse($line);

            case 'pick_starting_regions':
                return \Mastercoding\Conquest\Command\StartingRegions\Pick::create($components);
            case 'update_map':
                return \Mastercoding\Conquest\Command\UpdateMap\Update::create($components);
            case 'opponent_moves':
                return \Mastercoding\Conquest\Command\OpponentMoves\Moves::create($components);
        }

        return null;

    }

}