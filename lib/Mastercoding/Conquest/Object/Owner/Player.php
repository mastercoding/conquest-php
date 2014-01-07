<?php

namespace Mastercoding\Conquest\Object\Owner;

class Player extends AbstractOwner
{

    /**
     * You
     *
     * @var string
     */
    const YOU = 'your_bot';

    /**
     * The opponent
     *
     * @var string
     */
    const OPPONENT = 'opponent_bot';

    /**
     * Who (your_bot, opponent_bot)
     *
     * @var string
     */
    private $who;

    /**
     * Construct with name
     *
     * @param string $name
     */
    public function __construct($who, $name)
    {

        parent::__construct($name);
        $this->who = $who;

    }

    /**
     * Get who
     *
     * @return string
     */
    public function getWho()
    {
        return $this->who;
    }

}
