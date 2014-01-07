<?php

namespace Mastercoding\Conquest\Command\Parser;

class Parser implements ParserInterface
{

    /**
     * Parse the line into an input command
     *
     * @param string $line
     * @return \Mastercoding\Conquest\Command\Input
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
        }

        return null;

    }

}