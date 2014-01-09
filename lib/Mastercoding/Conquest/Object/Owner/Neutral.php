<?php

namespace Mastercoding\Conquest\Object\Owner;

class Neutral extends AbstractOwner
{
    public function __construct()
    {
        parent::__construct(AbstractOwner::NEUTRAL);
    }

}
