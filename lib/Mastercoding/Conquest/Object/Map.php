<?php

namespace Mastercoding\Conquest\Object;

class Map extends \Mastercoding\Conquest\Object\AbstractObject
{

    /**
     * A map has a few continents
     *
     * @var SplObjectStorage
     */
    private $continents;

    /**
     * Construct a new map, empty at first
     */
    public function __construct()
    {
        $this->continents = new \SplObjectStorage;
    }

    /**
     * Add a continent to the map
     *
     * @param Continent $continent
     */
    public function addContinent(Continent $continent)
    {
        $this->continents->attach($continent);
        return $this;
    }

    /**
     * Get a continent by the continent id
     *
     * @return Continent|null
     */
    public function getContinentById($id)
    {

        // loop and see if it exists
        foreach ($this->continents as $continent) {
            if ($continent->getId() == $id) {
                return $continent;
            }
        }

        // not found
        return null;

    }

    /**
     * Get region by id
     *
     * @param int $id
     * @return Region
     */
    public function getRegionById($id)
    {

        // loop continents and search for region
        foreach ($this->continents as $continent) {

            $region = $continent->getRegionById($id);
            if (null !== $region) {
                return $region;
            }

        }

        // not found
        return null;
    }

}
