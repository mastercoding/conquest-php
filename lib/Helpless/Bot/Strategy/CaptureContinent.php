<?php

namespace Helpless\Bot\Strategy;

class CaptureContinent implements \Mastercoding\Conquest\Bot\Strategy\RegionPicker\RegionPickerInterface, \Mastercoding\Conquest\Bot\Strategy\AttackTransfer\AttackTransferInterface, \Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\ArmyPlacementInterface
{
    /**
     * The continent to caputre
     *
     * @var \Mastercoding\Conquest\Object\Continent
     */
    private $continent;

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
     * @inheritDoc
     */
    public function placeArmies(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\PlaceArmies $move, $amountLeft, \Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand)
    {

        // get regions owned by me
        $myRegions = \Mastercoding\Conquest\Bot\Helper\General::regionsInContinentByOwner($bot->getMap(), $this->continent, $bot->getMap()->getYou());

        // loop regions to see if any of them have opponent owned neighbors, if
        // so pick this one, otherwise, pick neutral/unknown
        foreach ($myRegions as $region) {

            // loop neighbors
            $priorityQueue = new \SplPriorityQueue;
            foreach ($region->getNeighbors() as $neighbor) {

                // at least not mine
                if ($neighbor->getOwner() != $bot->getMap()->getYou()) {

                    // priority
                    if ($neighbor->getOwner() == AbstractOwner::NEUTRAL || $neighbor->getOwner() == AbstractOwner::UNKNOWN) {
                        $priorityQueue->insert($neighbor, 1);
                    } else {
                        $priorityQueue->insert($neighbor, 2);
                    }

                }

            }

            // get region with top priority
            $topPriority = $priorityQueue->top();
            if ($topPriority) {

                // ok, all armies on this one (better implementation to come)
                $amount = $amountLeft;
                $move->addPlaceArmies($topPriority->getId(), $amount);
                return array($move, $amountLeft - $amount);

            }

            // no armies placed by me
            return array($move, $amountLeft);

        }

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
     * @inheritDoc
     */
    public function attackTransfer(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\AttackTransfer $move, \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand)
    {

        // transfer armies from region with all me neighbours

    }

}
