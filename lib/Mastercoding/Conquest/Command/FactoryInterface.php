<?php

namespace Mastercoding\Conquest\Command;

interface FactoryInterface
{

    /**
     * Create a instance of the class with the user of components parsed from
     * input
     *
     * @param Array $components
     * @return \Mastercoding\Conquest\Command
     */
    public static function create($components);

}