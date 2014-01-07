<?php

namespace Mastercoding\Conquest\Object;

class Continent extends \Mastercoding\Conquest\Object\AbstractObject
{

    /**
     * A continent has an id
     *
     * @var int
     */
    private $id;

    /**
     * The bonus for fully capturing this region
     *
     * @var int
     */
    private $bonus;

    /**
     * A continent has regions
     */
    private $regions;

    /**
     * Create a continent with the id and bonus amount
     *
     * @param int $id
     * @param int $bonus
     */
    public function __construct($id, $bonus)
    {
        $this->id = $id;
        $this->bonus = $bonus;
        $this->regions = new \SplObjectStorage;
    }

    /**
     * Get the continent id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the bonus
     *
     * @return int
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * Add a region to the continent
     *
     * @param Region $region
     */
    public function addRegion(Region $region)
    {
        $this->regions->attach($region);
        return $this;
    }

    /**
     * Get regions in this continent
     *
     * @return \SplObjectStorage
     */
    public function getRegions()
    {
        return $this->regions;
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
        foreach ($this->regions as $region) {

            if ($region->getId() == $id) {
                return $region;
            }

        }

        // not found
        return null;
    }

}
