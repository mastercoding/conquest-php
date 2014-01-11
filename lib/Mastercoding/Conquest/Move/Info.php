<?php

namespace Mastercoding\Conquest\Move;

class Info extends AbstractMove
{
    /**
     * The info for this info move
     *
     * @var string
     */
    private $info;

    /**
     * Set info for info move
     *
     * @param string $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @inheritDoc
     */
    public function toString()
    {
        return $this->getInfo();
    }

}
