<?php

class MoveTest extends \PHPUnit_Framework_TestCase
{

    public function testPlaceArmies()
    {

        $move = new \Mastercoding\Conquest\Move\PlaceArmies;
        $move->addPlaceArmies(new \Mastercoding\Conquest\Object\Region(1, 1), 5);
        $move->addPlaceArmies(new \Mastercoding\Conquest\Object\Region(3, 1), 2);

        // output
        $this->assertEquals('{{you}} place_armies 1 5,{{you}} place_armies 3 2', $move->toString());

    }

    public function testAttackTransfer()
    {

        $move = new \Mastercoding\Conquest\Move\AttackTransfer;
        $move->addAttackTransfer(new \Mastercoding\Conquest\Object\Region(1, 1), new \Mastercoding\Conquest\Object\Region(3, 1), 3);
        $move->addAttackTransfer(new \Mastercoding\Conquest\Object\Region(1, 1), new \Mastercoding\Conquest\Object\Region(4, 1), 2);

        // output
        $this->assertEquals('{{you}} attack/transfer 1 3 3,{{you}} attack/transfer 1 4 2', $move->toString());

    }

}
