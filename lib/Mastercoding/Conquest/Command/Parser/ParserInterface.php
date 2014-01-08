<?php

namespace Mastercoding\Conquest\Command\Parser;

interface ParserInterface
{
    /**
     * Parse the line into an input command
     *
     * @param string $line
     * @return \Mastercoding\Conquest\Command\Input
     * @throws Exception
     */
    public function parse($line);

}