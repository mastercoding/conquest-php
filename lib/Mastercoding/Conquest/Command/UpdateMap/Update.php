<?php

namespace Mastercoding\Conquest\Command\UpdateMap;

class Update extends \Mastercoding\Conquest\Command\AbstractCommand implements \Mastercoding\Conquest\Command\FactoryInterface
{

    /**
     * The timeout the bot has to respond
     *
     * @var int
     */
    private $updates;

    /**
     * @inheritDoc
     */
    public static function create($components)
    {

        // set timeout
        $update = new self();

        // loop updates
        for ($i = 1; $i < count($components); $i += 3) {
            $update->addUpdate(array('regionId' => $components[$i], 'owner' => $components[$i + 1], 'armies' => $components[$i + 2]));
        }

        // set and return
        return $update;

    }

    /**
     * Construct
     */
    public function __construct()
    {
        $this->updates = array();
    }

    /**
     * Add update
     *
     * @param Array $update
     */
    public function addUpdate($update)
    {
        $this->updates[] = $update;
        return $this;
    }

    /**
     * Get updates ids
     *
     * @return Array
     */
    public function getUpdates()
    {
        return $this->updates;
    }

}
