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
     * Check if all neighbors for a region are yours
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Mastercoding\Conquest\Object\Region $region
     */
    public static function allYoursNeighbors(\Mastercoding\Conquest\Object\map $map, \Mastercoding\Conquest\Object\Region $region)
    {

        // neighbors
        foreach ($region->getNeighbors() as $neighbor) {

            // not all mine, continue in parent loop
            if ($neighbor->getOwner() != $map->getYou()) {
                return false;
            }

        }

        return true;

    }

    /**
     * Check if all neighbors are neutral or yours
     *
     * @param \Mastercoding\Conquest\Object\Map $map
     * @param \Mastercoding\Conquest\Object\Region $region
     */
    public static function allNeutralOrYoursNeighbors(\Mastercoding\Conquest\Object\map $map, \Mastercoding\Conquest\Object\Region $region)
    {

        // neighbors
        foreach ($region->getNeighbors() as $neighbor) {

            // not all mine, continue in parent loop
            if ($neighbor->getOwner() != $map->getYou() && $neighbor->getOwner()->getName() != \Mastercoding\Conquest\Object\Owner\AbstractOwner::NEUTRAL) {
                return false;
            }

        }

        return true;

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
                    $regions->attach($region);
                }

            }

        }
        return $regions;

    }

}
