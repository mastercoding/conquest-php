<?php

namespace Mastercoding\Conquest\Command\Parser;

interface ParserInterface
{
    /**
     * Parse the line into an input command
     *
     * @param string $line
     * @return \Mastercoding\Conquest\Command\Input
     */
    public function parse($line);

}