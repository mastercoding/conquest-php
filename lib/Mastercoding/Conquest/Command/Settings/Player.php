<?php

namespace Mastercoding\Conquest\Command\Settings;

class Player extends \Mastercoding\Conquest\Command\AbstractCommand implements \Mastercoding\Conquest\Command\FactoryInterface
{

    /**
     * The actual bot object
     *
     * @var \Mastercoding\Conquest\Object\Player
     */
    private $player;

    /**
     * @inheritDoc
     */
    public static function create($components)
    {
        return new self($components[1], $components[2]);
    }

    /**
     * Construct with name
     *
     * @param string $name
     */
    public function __construct($who, $name)
    {
        $this->player = new \Mastercoding\Conquest\Object\Owner\Player($who, $name);
    }

    /**
     * Get bot
     *
     * @return \Mastercoding\Conquest\Object\Bot
     */
    public function getPlayer()
    {
        return $this->player;
    }

}
