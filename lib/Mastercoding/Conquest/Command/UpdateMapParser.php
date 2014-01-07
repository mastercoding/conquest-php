<?php

namespace Mastercoding\Conquest\Command;

class UpdateMapParser implements \Mastercoding\Conquest\Command\Parser\ParserInterface
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

            default:
                throw new \Exception('Unimplemented update map: ' . $components[1]);
        
        }

    }

}