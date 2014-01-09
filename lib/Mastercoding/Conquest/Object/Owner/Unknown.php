<?php

namespace Mastercoding\Conquest\Object\Owner;

class Unknown extends AbstractOwner
{

    public function __construct()
    {
        parent::__construct(AbstractOwner::UNKNOWN);
    }

}
