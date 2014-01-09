<?php

namespace Mastercoding\Conquest\Object;

class Region extends \Mastercoding\Conquest\Object\AbstractObject
{

    /**
     * A region has an id
     *
     * @var int
     */
    private $id;

    /**
     * The parent continent id
     *
     * @var id
     */
    private $continentId;

    /**
     * The neighbors of this object
     *
     * @var \SplObjectStorage
     */
    private $neighbors;

    /**
     * Number of armies on this region
     *
     * @var int
     */
    private $armies = 2;

    /**
     * Owner of this region
     *
     * @var \Mastercoding\Conquest\Object\Owner\AbstractOwner
     */
    private $owner;

    /**
     * Create a region with the id
     *
     * @param int $id
     * @praam int $bonus
     */
    public function __construct($id, $continentId)
    {
        $this->id = $id;
        $this->continentId = $continentId;
        $this->neighbors = new \SplObjectStorage;
        $this->owner = new \Mastercoding\Conquest\Object\Owner\Unknown;
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
     * Get the parent continent
     *
     * @return int
     */
    public function getContinentId()
    {
        return $this->continentId;
    }

    /**
     * Check if object has neighbors
     *
     * @return bool
     */
    public function hasNeighbors()
    {
        return $this->neighbors->count() > 0;
    }

    /**
     * Get the neighbors for this object
     *
     * @return \SplObjectStorage
     */
    public function getNeighbors()
    {
        return $this->neighbors;
    }

    /**
     * Add neighbor
     *
     * @param \Mastercoding\Conquest\Object\Region $neighbor
     */
    public function addNeighbor(\Mastercoding\Conquest\Object\Region $neighbor)
    {
        $this->neighbors->attach($neighbor);
        return $this;
    }

    /**
     * Set number of armies
     *
     * @param int $armies
     */
    public function setArmies($armies)
    {
        $this->armies = $armies;
        return $this;
    }

    /**
     * Add number of armies
     *
     * @param int $armies
     */
    public function addArmies($armies)
    {
        $this->armies += $armies;
        return $this;
    }

    /**
     * Get nr armies
     *
     * @return int
     */
    public function getArmies()
    {
        return $this->armies;
    }

    /**
     * Set owner
     *
     * @param Owner
     */
    public function setOwner(\Mastercoding\Conquest\Object\Owner\AbstractOwner $owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Get owner
     *
     * @return \Mastercoding\Conquest\Object\Owner\AbstractOwner
     */
    public function getOwner()
    {
        return $this->owner;
    }

}
