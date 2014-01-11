<?php

namespace Helpless\Bot\Strategy;

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
        return $move;
    }

    /**
     * Attack the regions in the most efficient way (or some if all is not
     * possible)
     */
    private function attackRegions(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\AttackTransfer $move, Array $regions)
    {

        foreach ($regions as $region) {

            // wealthy enough to attack?
            $neededArmies = \Mastercoding\Conquest\Bot\Helper\Amount::amountToAttack($region->getArmies(), self::ADDITIONAL_ARMIES_PERCENTAGE);

            // find wealthy neigbor
            foreach ($region->getNeighbors() as $neighbor) {

                if ($neighbor->getOwner() == $bot->getMap()->getYou()) {

                    // enough
                    if ($neighbor->getArmies() >= $neededArmies) {

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
        foreach ($this->continent->getRegions() as $region) {

            // mine?
            if ($region->getOwner() == $bot->getMap()->getYou()) {

                // neighbours that are not mine?
                $notMineNeighbors = array();
                foreach ($region->getNeighbors() as $neighbor) {

                    // add
                    if ($neighbor->getOwner() != $bot->getMap()->getYou() && $neighbor->getContinentId() == $this->continent->getId()) {
                        $notMineNeighbors[] = $neighbor;
                    }

                }

                // attack those
                $move = $this->attackRegions($bot, $move, $notMineNeighbors);

            }

        }
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
