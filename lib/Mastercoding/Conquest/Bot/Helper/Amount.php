<?php

namespace Mastercoding\Conquest\Bot\Helper;

class Amount
{

    /**
     * Each attacking army has 60% chance to destroy 1 defending army
     *
     * @var float
     */
    const ATTACK_VS_DEFEND = 0.6;

    /**
     * Calculate amount of armies need to win a fight
     *
     * @param int $defendingArmies
     * @param int $addedSecurity (in percentage)
     */
    public static function amountToAttack($defendingArmies, $addedSecurity = 0)
    {
        // armies needed
        $armiesNeeded = $defendingArmies / self::ATTACK_VS_DEFEND;

        // we want to add security, fine
        $armiesNeeded += $armiesNeeded * ($addedSecurity / 100);
        return ceil($armiesNeeded);

    }

    /**
     * Calculate amount of armies need to defend a region from an attacking region with $attackingArmies
     *
     * @param int $attackingArmies
     * @param int $addedSecurity (in percentage)
     */
    public static function amountToDefend($attackingArmies, $addedSecurity = 0)
    {

        // needed ( we need 1 more to actually keep the region)
        $armiesNeeded = 1 + ($attackingArmies * self::ATTACK_VS_DEFEND);

        // we want to add security, fine
        $armiesNeeded += $armiesNeeded * ($addedSecurity / 100);
        return ceil($armiesNeeded);

    }

}
