<?php

namespace Mastercoding\Conquest\Move;

class PickRandomRegions extends AbstractMove
{
    /**
     * Random regions are picked if non valid response is returned
     */
    public function toString()
    {
        $quotes = file(dirname(__FILE__) . '/../../../../quotes.txt');
        $quote = trim($quotes[array_rand($quotes, 1)]);
        return $quote;
    }

}
