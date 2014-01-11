<?php

namespace Helpless\Bot\Strategy;

use \Mastercoding\Conquest\Bot\Helper;

class CrossContinent extends \Mastercoding\Conquest\Bot\Strategy\AbstractStrategy implements \Mastercoding\Conquest\Bot\Strategy\RegionPicker\RegionPickerInterface, \Mastercoding\Conquest\Bot\Strategy\AttackTransfer\AttackTransferInterface, \Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\ArmyPlacementInterface
{

    /**
     * Need x percent additional armies then the theoretical amount to start an
     * attack
     *
     * @var int
     */
    const ADDITIONAL_ARMIES_PERCENTAGE = 30;

    /**
     * Continent from
     *
     * @var \Mastercoding\Conquest\Object\Continent
     */
    private $from;

    /**
     * Continent to
     *
     * @var \Mastercoding\Conquest\Object\Continent
     */
    private $to;

    /**
     * @inheritDoc
     */
    public function isDone(\Mastercoding\Conquest\Bot\AbstractBot $bot)
    {
        $allYours = Helper\General::regionsInContinentByOwner($bot->getMap(), $this->to, $bot->getMap()->getYou());
        return (count($allYours) >= 1);
    }

    /**
     * Set continents
     *
     * @param \Mastercoding\Conquest\Object\Continent $from
     * @param \Mastercoding\Conquest\Object\Continent $to
     */
    public function setContinents(\Mastercoding\Conquest\Object\Continent $from, \Mastercoding\Conquest\Object\Continent $to)
    {
        $this->from = $from;
        $this->to = $to;
        return $this;
    }

    /**
     * Get top linked (with most armies) region
     *
     * @param \Mastercoding\Conquest\Bot\AbstractBot $bot
     * @return \Mastercoding\Conquest\Object\Region
     */
    private function getTopLinkedRegion(\Mastercoding\Conquest\Bot\AbstractBot $bot)
    {

        // get linked region with highest army count
        $linkedRegions = new \SplPriorityQueue;

        // from
        $borderRegions = Helper\General::borderRegionsInContinent($bot->getMap(), $this->from);
        foreach ($borderRegions as $region) {
            foreach ($region->getNeighbors() as $neighbor) {
                if ($neighbor->getContinentId() == $this->to->getId()) {
                    $linkedRegions->insert($region, $region->getArmies());
                }
            }
        }

        // get top linked
        $topLinkedRegion = $linkedRegions->top();
        return $topLinkedRegion;

    }

    /**
     * @inheritDoc
     */
    public function placeArmies(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\PlaceArmies $move, $amountLeft, \Mastercoding\Conquest\Command\Go\PlaceArmies $placeArmiesCommand)
    {

        // only if from captured
        $allYours = Helper\General::regionsInContinentByOwner($bot->getMap(), $this->to, $bot->getMap()->getYou());
        if (count($allYours) == 0 && Helper\General::continentCaptured($bot->getMap(), $this->from)) {

            // get top linked
            $topLinkedRegion = $this->getTopLinkedRegion($bot);
            $move->addPlaceArmies($topLinkedRegion->getId(), $amountLeft);
            return array($move, 0);

        }

        // nothing
        return array($move, $amountLeft);
    }

    /**
     * @inheritDoc
     */
    public function pickRegions(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\PickRegions $move, $amountLeft, \Mastercoding\Conquest\Command\StartingRegions\Pick $pickCommand)
    {

        // not interesting for this strategy
        return array($move, $amountLeft);

    }

    /**
     * @inheritDoc
     */
    public function attackTransfer(\Mastercoding\Conquest\Bot\AbstractBot $bot, \Mastercoding\Conquest\Move\AttackTransfer $move, \Mastercoding\Conquest\Command\Go\AttackTransfer $attackTransferCommand)
    {

        // only if from captured
        $allYours = Helper\General::regionsInContinentByOwner($bot->getMap(), $this->to, $bot->getMap()->getYou());
        if (count($allYours) == 0 && Helper\General::continentCaptured($bot->getMap(), $this->from)) {

            // get top linked
            $fromRegion = $this->getTopLinkedRegion($bot);

            // enough
            $toRegion = null;
            foreach ($fromRegion->getNeighbors() as $neighbor) {
                if ($neighbor->getContinentId() == $this->to->getId()) {
                    $toRegion = $neighbor;
                    break;
                }
            }

            // enough
            $neededArmies = \Mastercoding\Conquest\Bot\Helper\Amount::amountToAttack($toRegion->getArmies(), self::ADDITIONAL_ARMIES_PERCENTAGE);
            if ($fromRegion->getArmies() > $neededArmies) {

                // attack with this one, all armies!
                $fromRegion->removeArmies($neededArmies);
                $move->addAttackTransfer($fromRegion->getId(), $toRegion->getId(), $fromRegion->getArmies() - 1);

            }

        }
        return $move;
    }

}
