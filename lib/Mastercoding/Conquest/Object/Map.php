<?php

namespace Mastercoding\Conquest\Object;

class Map extends \Mastercoding\Conquest\Object\AbstractObject
{

    /**
     * A map has a few players (two for now)
     *
     * @var \SplObjectStorage
     */
    private $players;

    /**
     * The number of armies you start with every round. This increases
     * by capturing continents
     *
     * @var int
     */
    private $startingArmies;

    /**
     * A map has a few continents
     *
     * @var \SplObjectStorage
     */
    private $continents;

    /**
     * The round number (by counting place armies moves)
     *
     * @var int
     */
    private $round;

    /**
     * Construct a new map, empty at first
     */
    public function __construct()
    {
        $this->continents = new \SplObjectStorage;
        $this->players = new \SplObjectStorage;

        // 5 as default
        $this->startingArmies = 5;
        $this->round = 0;

    }

    /**
     * Increase round
     *
     * @param int $round
     */
    public function increaseRound()
    {
        $this->round += 1;
        return $this;
    }

    /**
     * Set round number
     *
     * @param int $round
     */
    public function setRound($round)
    {
        $this->round = $round;
        return $this;
    }

    /**
     * Get round number
     *
     * @return int
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * Set the starting armies amount
     *
     * @param int
     */
    public function setStartingArmies($amount)
    {
        $this->startingArmies = $amount;
        return $this;
    }

    /**
     * Get the starting armies amount
     *
     * @return int
     */
    public function getStartingArmies()
    {
        return $this->startingArmies;
    }

    /**
     * Add a player to the map
     *
     * @param Owner\Player $player
     */
    public function addPlayer(Owner\Player $player)
    {
        $this->players->attach($player);
        return $this;
    }

    /**
     * Get your player object (your_bot)
     *
     * @return Owner\Player
     */
    public function getYou()
    {

        foreach ($this->players as $player) {
            if ($player->getWho() == Owner\Player::YOU) {
                return $player;
            }

        }

    }

    /**
     * Get players
     *
     * @return array
     */
    public function getPlayers()
    {
        return $this->players;
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
     * Get all continents
     *
     * @return array
     */
    public function getContinents()
    {
        return $this->continents;
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

    /**
     * Get regions for player
     *
     * @return Array
     */
    public function getRegionsForPlayer(Owner\Player $player)
    {

        $myRegions = new \SplObjectStorage;
        foreach ($this->getContinents() as $continent) {

            foreach ($continent->getRegions() as $region) {

                if ($region->getOwner()->getName() == $player->getName()) {
                    $myRegions->attach($region);
                }

            }

        }

        return $myRegions;

    }

}
