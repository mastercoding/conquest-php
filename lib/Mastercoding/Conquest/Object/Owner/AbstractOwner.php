<?php

namespace Mastercoding\Conquest\Object\Owner;

abstract class AbstractOwner extends \Mastercoding\Conquest\Object\AbstractObject
{

    /**
     * Neutral type
     *
     * @var string
     */
    const NEUTRAL = 'neutral';

    /**
     * Unknown type
     *
     * @var string
     */
    const UNKNOWN = 'unknown';

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
