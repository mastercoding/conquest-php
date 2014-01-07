<?php

namespace Mastercoding\Conquest\Command\SetupMap;

class Neighbors extends \Mastercoding\Conquest\Command\AbstractCommand implements \Mastercoding\Conquest\Command\FactoryInterface
{

    /**
     * The parsed neighbors
     *
     * @var Array
     */
    private $neighbors;

    /**
     * The neighbors expanded (bidirectional)
     *
     * @var Array
     */
    private $neighborsExpanded;

    /**
     * @inheritDoc
     */
    public static function create($components)
    {

        $neighbors = new self();
        for ($i = 2; $i < count($components); $i += 2) {

            $neighbors->setNeighbor($components[$i], explode(',', $components[$i + 1]));

        }

        // expand
        $neighbors->expand();

        return $neighbors;

    }

    /**
     * Construct
     */
    public function __construct()
    {
        $this->neighbors = array();
        $this->neighborsExpanded = array();
    }

    /**
     * Set neighbor mapping
     *
     * @param int $regionId
     * @param Array $neighborArray
     */
    public function setNeighbor($regionId, Array $neighborArray)
    {
        $this->neighbors[$regionId] = $neighborArray;
    }

    /**
     * Get neighbors for region
     *
     * @return Array
     */
    public function getNeighbors()
    {
        return $this->neighborsExpanded;
    }

    /**
     * Expand the neighbors to allow bidirectional
     */
    public function expand()
    {

        $this->neighborsExpanded = array();
        foreach ($this->neighbors as $id => $neighborIds) {

            foreach ($neighborIds as $neighborId) {

                $this->neighborsExpanded[$id][] = $neighborId;
                $this->neighborsExpanded[$neighborId][] = $id;

            }

        }

        // unique & sort
        array_map('array_unique', $this->neighborsExpanded);
        array_map('sort', $this->neighborsExpanded);

    }

}
