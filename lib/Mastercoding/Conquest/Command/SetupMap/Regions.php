<?php

namespace Mastercoding\Conquest\Command\SetupMap;

class Regions extends \Mastercoding\Conquest\Command\AbstractCommand implements \Mastercoding\Conquest\Command\FactoryInterface
{

    /**
     * The actual bot object
     *
     * @var \SplObjectStorage
     */
    private $regions;

    /**
     * @inheritDoc
     */
    public static function create($components)
    {

        $regions = new self();
        for ($i = 2; $i < count($components); $i += 2) {

            // the region
            $region = new \Mastercoding\Conquest\Object\Region($components[$i], $components[$i + 1]);
            $regions->addRegion($region);

        }

        return $regions;

    }

    /**
     * Construct
     */
    public function __construct()
    {
        $this->regions = new \SplObjectStorage;
    }

    /**
     * Add continent to storage
     *
     * @param \Mastercoding\Conquest\Object\Region $region
     */
    public function addRegion(\Mastercoding\Conquest\Object\Region $region)
    {
        $this->regions->attach($region);
        return $this;

    }

    /**
     * Get regions
     *
     * @return \SplObjectStorage
     */
    public function getRegions()
    {
        return $this->regions;
    }

}
