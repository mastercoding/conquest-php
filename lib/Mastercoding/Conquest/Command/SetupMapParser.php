<?php

namespace Mastercoding\Conquest\Command;

class SetupMapParser implements \Mastercoding\Conquest\Command\Parser\ParserInterface
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

            case 'super_regions':
                return SetupMap\Continents::create($components);

            case 'regions':
                return SetupMap\Regions::create($components);

            case 'neighbors':
                return SetupMap\Neighbors::create($components);

            default:
                throw new \Exception('Unimplemented setup_map: ' . $components[1]);
        }

    }

}