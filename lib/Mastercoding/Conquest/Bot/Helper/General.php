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

    /**
     * Get regions owned by particularowner
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Mastercoding\Conquest\Object\Continent $continent
     * @param \Mastercoding\Conquest\Object\Owner\Owner $owner
     * @return \SplObjectStorage
     */
    public static function regionsInContinentByOwner(\Mastercoding\Conquest\Object\map $map, \Mastercoding\Conquest\Object\Continent $continent, \Mastercoding\Conquest\Object\Owner\AbstractOwner $owner)
    {

        $regions = new \SplObjectStorage;
        foreach ($continent->getRegions() as $region) {
            if ($region->getOwner() == $owner) {
                $regions->attach($region);
            }
        }
        return $regions;

    }

    /**
     * Get regions in a continent that link to another continent
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Mastercoding\Conquest\Object\Continent $continent
     * @return \SplObjectStorage
     */
    public static function borderRegionsInContinent(\Mastercoding\Conquest\Object\map $map, \Mastercoding\Conquest\Object\Continent $continent)
    {

        $regions = new \SplObjectStorage;
        foreach ($continent->getRegions() as $region) {
            foreach ($region->getNeighbors() as $neighbor) {

                if ($neighbor->getContinentId() != $continent->getId()) {
                    $regions->attach($neighbor);
                }

            }

        }
        return $regions;

    }

}
