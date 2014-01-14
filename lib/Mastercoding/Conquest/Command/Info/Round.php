<?php

namespace Mastercoding\Conquest\Command\Info;

class Round extends \Mastercoding\Conquest\Command\AbstractCommand implements \Mastercoding\Conquest\Command\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public static function create($components)
    {

        // set timeout
        $armies = new self();
        return $armies;

    }

    /**
     * Construct
     */
    public function __construct()
    {
    }

}