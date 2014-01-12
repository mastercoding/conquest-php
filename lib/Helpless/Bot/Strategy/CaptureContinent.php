<?php

namespace Helpless\Bot\Strategy;

use \Mastercoding\Conquest\Bot\Helper;

class CaptureContinent extends \Mastercoding\Conquest\Bot\Strategy\AbstractStrategy implements \Mastercoding\Conquest\Bot\Strategy\RegionPicker\RegionPickerInterface, \Mastercoding\Conquest\Bot\Strategy\AttackTransfer\AttackTransferInterface, \Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\ArmyPlacementInterface
{

    /**
     * Need x percent additional armies then the theoretical amount to start an
     * attack
     *
     * @var int
     */
    const ADDITIONAL_ARMIES_PERCENTAGE = 30;

    /**
     * The continent to caputre
     *
     * @var \Mastercoding\Conquest\Object\Continent
     */
    private $continent;

    /**
     * @inheritDoc
     */
    public function isDone(\Mastercoding\Conquest\Bot\AbstractBot $bot)
    {
        return Helper\General::continentCaptured($bot->getMap(), $this->continent);
    }

    /**
     * Set the continent to capture
     *
     * @param \Mastercoding\Conquest\Object\Continent $continent
     */
    public function setContinent(\Mastercoding\Conquest\Object\Continent $continent)
    {
        $this->continent = $continent;
    }

    /**
     * Get the continent to capture
     *
     * @return \Mastercoding\Conquest\Object\Continent
     */
    public function getContinent()
    {
        return $this->continent;
    }

    /**
     * @inheritDoc
     */
    public function placeArmies(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\PlaceArmies $move, $amountLeft, \Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand)
    {

        // captured, defend borders
        if (Helper\General::continentCaptured($bot->getMap(), $this->continent)) {

            // border regions
            $borderRegions = \Mastercoding\Conquest\Bot\Helper\General::borderRegionsInContinent($bot->getMap(), $this->continent);
            foreach ($borderRegions as $region) {

                $myArmies = $region->getArmies();
                foreach ($region->getNeighbors() as $neighbor) {

                    // not own region
                    if ($neighbor->getOwner() != $bot->getMap()->getYou()) {

                        $neededArmies = Helper\Amount::amountToDefend($neighbor->getArmies(), self::ADDITIONAL_ARMIES_PERCENTAGE);
                        if ($neededArmies > $myArmies) {

                            //
                            $additionalArmies = $neededArmies - $myArmies;
                            $amountToPlace = min($additionalArmies, $amountLeft);
                            $amountLeft -= $amountToPlace;

                            // place armies
                            $move->addPlaceArmies($region->getId(), $amountToPlace);

                        }

                    }

                }

            }

            return array($move, $amountLeft);
        }

        // get regions owned by me
        $myRegions = \Mastercoding\Conquest\Bot\Helper\General::regionsInContinentByOwner($bot->getMap(), $this->continent, $bot->getMap()->getYou());

        // loop regions to see if any of them have opponent owned neighbors, if
        // so pick this one, otherwise, pick neutral/unknown
        $priorityQueue = new \SplPriorityQueue;
        foreach ($myRegions as $region) {

            // loop neighbors
            $notMeNeighborCount = 0;
            foreach ($region->getNeighbors() as $neighbor) {

                // at least not mine
                if ($neighbor->getOwner() != $bot->getMap()->getYou()) {
                    $notMeNeighborCount += 1 * ($neighbor->getContinentId() == $this->continent->getId() ? 10 : 1);
                }

            }

            if ($notMeNeighborCount > 0) {
                $priorityQueue->insert($region, $notMeNeighborCount);
            }

        }

        // get region with top priority
        if (count($priorityQueue) > 0) {

            // top
            $topPriority = $priorityQueue->top();

            // ok, all armies on this one (better implementation to come)
            $amount = $amountLeft;
            $move->addPlaceArmies($topPriority->getId(), $amount);
            
            return array($move, $amountLeft - $amount);

        }

        // no armies placed by me
        return array($move, $amountLeft);

    }

    /**
     * @inheritDoc
     */
    public function pickRegions(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\PickRegions $move, $amountLeft, \Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand)
    {

        // choice
        $choices = array_diff($pickCommand->getRegionIds(), $move->getRegionIds());

        // as many from this continent as possible
        foreach ($choices as $regionId) {

            if (null !== $this->continent->getRegionById($regionId)) {
                $move->addRegionId($regionId);
                $amountLeft--;
            }

            if ($amountLeft == 0) {
                break;
            }

        }

        // return
        return array($move, $amountLeft);

    }

    /**
     * @see self::attackTransfer
     */
    private function transfers(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\AttackTransfer $move, \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand)
    {

        // move from region with only me neighbors
        // to region with not only me neighbors,
        // or, if entire continent is ours, move to continent edges
        $borderRegions = \Mastercoding\Conquest\Bot\Helper\General::borderRegionsInContinent($bot->getMap(), $this->continent);

        // not all mine
        $notAllMineNeighboredRegions = new \SplObjectStorage;
        foreach ($this->continent->getRegions() as $region) {

            if ($bot->getMap()->getYou() == $region->getOwner() && !Helper\General::allYoursNeighbors($bot->getMap(), $region)) {
                $notAllMineNeighboredRegions->attach($region);
            }

        }

        // loop regions, again
        foreach ($this->continent->getRegions() as $region) {

            // only one?
            if ($region->getArmies() == 1) {
                continue;
            }

            // all neighbors mine?
            if ($region->getOwner() == $bot->getMap()->getYou() && Helper\General::allYoursNeighbors($bot->getMap(), $region)) {

                // continent captured? Move to edge
                if (count($notAllMineNeighboredRegions) == 0) {

                    // closest edge
                    try {
                        $closestEdge = Helper\Path::closestRegion($bot->getMap(), $region, $borderRegions, true);
                        if (null !== $closestEdge) {

                            $path = Helper\Path::shortestPath($bot->getMap(), $closestEdge, $region, true);
                            $move->addAttackTransfer($region->getId(), $path[1]->getId(), $region->getArmies() - 1);

                        }

                    } catch ( \Exception $e ) {
                        
                        // region is border, move to other continent?
                        
                    }

                } else {

                    // shortest path to region with not all mine
                    $closestRegion = Helper\Path::closestRegion($bot->getMap(), $region, $notAllMineNeighboredRegions, true);
                    if (null !== $closestRegion) {

                        $path = Helper\Path::shortestPath($bot->getMap(), $closestRegion, $region, true);
                        $move->addAttackTransfer($region->getId(), $path[1]->getId(), $region->getArmies() - 1);
                    }

                }

            }

        }

        return $move;
    }

    /**
     * Attack the regions in the most efficient way (or some if all is not
     * possible)
     */
    private function attackRegions(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\AttackTransfer $move, \SplObjectStorage $regions)
    {

        foreach ($regions as $region) {

            // wealthy enough to attack?
            $neededArmies = \Mastercoding\Conquest\Bot\Helper\Amount::amountToAttack($region->getArmies(), self::ADDITIONAL_ARMIES_PERCENTAGE);

            // find wealthy neigbor
            foreach ($region->getNeighbors() as $neighbor) {

                if ($neighbor->getOwner() == $bot->getMap()->getYou()) {

                    // enough (needs to be >, we need 1 left on region)
                    if ($neighbor->getArmies() > $neededArmies) {

                        // attack with this one
                        $neighbor->removeArmies($neededArmies);
                        $move->addAttackTransfer($neighbor->getId(), $region->getId(), $neededArmies);
                        break;

                    }

                }

            }

        }

        return $move;
    }

    /**
     * @see self::attackTransfer
     */
    private function attacks(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\AttackTransfer $move, \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand)
    {
        // attack continent regions
        $notMineNeighbors = new \SplObjectStorage;
        foreach ($this->continent->getRegions() as $region) {

            // mine?
            if ($region->getOwner() == $bot->getMap()->getYou()) {

                // neighbours that are not mine?
                foreach ($region->getNeighbors() as $neighbor) {

                    // add
                    if ($neighbor->getOwner() != $bot->getMap()->getYou() && $neighbor->getContinentId() == $this->continent->getId()) {
                        $notMineNeighbors->attach($neighbor);
                    }

                }

            }

        }

        // attack those
        $move = $this->attackRegions($bot, $move, $notMineNeighbors);
        return $move;
    }

    /**
     * @inheritDoc
     */
    public function attackTransfer(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\AttackTransfer $move, \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand)
    {

        // transfers
        $move = $this->transfers($bot, $move, $attackTransferCommand);
        $move = $this->attacks($bot, $move, $attackTransferCommand);

        return $move;

    }

}
