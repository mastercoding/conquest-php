<?php

class CommandTest extends \PHPUnit_Framework_TestCase
{

    public function testName()
    {

        // the parser
        $command = new \Mastercoding\Conquest\Command\Go\AttackTransfer;
        $this->assertEquals('Go\AttackTransfer', $command->getName());
        
    }

}