<?php

namespace Mastercoding\Conquest\Command;

abstract class AbstractCommand
{
    public function getName()
    {
        $name = get_class($this);
        $name = str_replace('Mastercoding\\Conquest\\Command\\', '', $name);
        return $name;
    }

}
