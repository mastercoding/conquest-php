<?php

namespace Mastercoding\Conquest\Command\OpponentMoves;

class Moves extends \Mastercoding\Conquest\Command\AbstractCommand implements \Mastercoding\Conquest\Command\FactoryInterface
{

    /**
     * The visible moves the opponent made
     *
     * @var int
     */
    private $moves;

    /**
     * @inheritDoc
     */
    public static function create($components)
    {

        // set timeout
        $moves = new self();

        // no moves?
        if (count($components) == 1) {
            return $moves;
        }

        for ($i = 1; $i < count($components); ) {

            switch ( $components[$i+1] ) {

                case 'place_armies':
                    $placeArmiesMove = new \Mastercoding\Conquest\Move\PlaceArmies;
                    $placeArmiesMove->setPlayerName($components[$i]);
                    $placeArmiesMove->addPlaceArmies($components[$i + 2], $components[$i + 3]);
                    $moves->addMove($placeArmiesMove);
                    $i += 4;
                    break;
                case 'attack/transfer':
                    $attackTransferMove = new \Mastercoding\Conquest\Move\AttackTransfer;
                    $attackTransferMove->setPlayerName($components[$i]);
                    $attackTransferMove->addAttackTransfer($components[$i + 2], $components[$i + 3], $components[$i + 4]);
                    $moves->addMove($attackTransferMove);
                    $i += 5;
                    break;
                default:
                    throw new \Mastercoding\Conquest\Command\Parser\GenericException('Invalid opponent moves');
            }

        }

        return $moves;

    }

    /**
     * Construct
     */
    public function __construct()
    {
        $this->moves = new \SplObjectStorage;
    }

    /**
     * Add move
     *
     * @param \Mastercoding\Conquest\Move\AbstractMove $move
     */
    public function addMove(\Mastercoding\Conquest\Move\AbstractMove $move)
    {
        $this->moves->attach($move);
        return $this;
    }

    /**
     * Get moves
     *
     * @return \SplObjectStorage
     */
    public function getMoves()
    {
        return $this->moves;
    }

}
