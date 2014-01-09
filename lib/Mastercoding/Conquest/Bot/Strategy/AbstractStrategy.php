<?php

namespace Mastercoding\Conquest\Bot\Strategy;

abstract class AbstractStrategy
{
    /**
     * The priority of this strategy
     *
     * @var int
     */
    private $priority = 0;

    /**
     * Set the priority
     *
     * @param int $priorty
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * Get the priority
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

}
