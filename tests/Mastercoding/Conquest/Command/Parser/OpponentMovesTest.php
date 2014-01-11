<?php

class OpponentMovesTest extends \PHPUnit_Framework_TestCase
{

    public function testOpponentMoves()
    {

        // the parser
        $inputParser = new \Mastercoding\Conquest\Command\Parser\Parser;

        // bot test
        $command = $inputParser->parse('opponent_moves player2 place_armies 40 2 player2 place_armies 40 1 player2 place_armies 11 1 player2 place_armies 11 1 player2 attack/transfer 40 42 10');
        $this->assertInstanceOf('\Mastercoding\Conquest\Command\OpponentMoves\Moves', $command);

        // nr moves
        $this->assertCount(5, $command->getMoves());
        
    }

    /**
     */
    public function testInvalidOpponentMoves()
    {

        // the parser
        $inputParser = new \Mastercoding\Conquest\Command\Parser\Parser;

        // bot test
        $this->setExpectedException('\Mastercoding\Conquest\Command\Parser\GenericException');
        $command = $inputParser->parse('opponent_moves blal');

    }

}