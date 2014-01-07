<?php

namespace Mastercoding\Conquest\Command\SetupMap;

class Continents extends \Mastercoding\Conquest\Command\AbstractCommand implements \Mastercoding\Conquest\Command\FactoryInterface
{

    /**
     * The actual bot object
     *
     * @var \SplObjectStorage
     */
    private $continents;

    /**
     * @inheritDoc
     */
    public static function create($components)
    {

        $continents = new self();
        for ($i = 2; $i < count($components); $i += 2) {

            $continent = new \Mastercoding\Conquest\Object\Continent($components[$i], $components[$i + 1]);
            $continents->addContinent($continent);

        }

        return $continents;

    }

    /**
     * Construct
     */
    public function __construct()
    {
        $this->continents = new \SplObjectStorage;
    }

    /**
     * Add continent to storage
     *
     * @param \Mastercoding\Conquest\Object\Continent $continent
     */
    public function addContinent(\Mastercoding\Conquest\Object\Continent $continent)
    {
        $this->continents->attach($continent);
        return $this;

    }

    /**
     * Get continents
     *
     * @return \SplObjectStorage
     */
    public function getContinents()
    {
        return $this->continents;
    }

}
