<?php

class MoveTest extends \PHPUnit_Framework_TestCase
{

    public function testPlaceArmies()
    {

        $move = new \Mastercoding\Conquest\Move\PlaceArmies;
        $move->setPlayerName('test');
        $move->addPlaceArmies(1, 5);
        $move->addPlaceArmies(3, 2);

        // output
        $this->assertEquals('test place_armies 1 5,test place_armies 3 2', $move->toString());

    }

    public function testAttackTransfer()
    {

        $move = new \Mastercoding\Conquest\Move\AttackTransfer;
        $move->setPlayerName('test');
        $move->addAttackTransfer(1, 3, 3);
        $move->addAttackTransfer(1, 4, 2);

        // output
        $this->assertEquals('test attack/transfer 1 3 3,test attack/transfer 1 4 2', $move->toString());

    }

}
