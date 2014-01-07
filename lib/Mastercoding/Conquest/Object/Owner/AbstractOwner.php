<?php

namespace Mastercoding\Conquest\Object\Owner;

abstract class AbstractOwner extends \Mastercoding\Conquest\Object\AbstractObject
{

    /**
     * Name of the bot
     *
     * @var int
     */
    private $name;

    /**
     * Construct with name
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}