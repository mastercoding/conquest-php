<?php

namespace Mastercoding\Conquest\Bot\Helper;

class General
{

    /**
     * Check if continent is fully captured
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Mastercoding\Conquest\Object\Continent $continent
     */
    public static function continentCaptured(\Mastercoding\Conquest\Object\map $map, \Mastercoding\Conquest\Object\Continent $continent)
    {
    
        // all regions yours?
        foreach ($continent->getRegions() as $region) {
            if ($region->getOwner() != $map->getYou())
                return false;
        }

        return true;

    }

}
