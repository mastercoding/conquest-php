<?php

namespace Mastercoding\Conquest;
class Event
{
    /**
     * After the setup_map is completed
     *
     * @var string
     */
    const SETUP_MAP_COMPLETE = 'SETUP_MAP_COMPLETE';

    /**
     * After the setup_map neighbors command has been processed
     *
     * @var string
     */
    const AFTER_SETUP_NEIGHBORS = 'AFTER_SETUP_NEIGHBORS';

    /**
     * Before the setup_map neighbors command has been processed
     *
     * @var string
     */
    const BEFORE_SETUP_NEIGHBORS = 'BEFORE_SETUP_NEIGHBORS';

    /**
     * After the map has been updated each round
     *
     * @var string
     */
    const AFTER_UPDATE_MAP = 'AFTER_UPDATE_MAP';

    /**
     * After update opponent moves
     *
     * @var string
     */
    const AFTER_UPDATE_OPPONENT_MOVES = 'AFTER_UPDATE_OPPONENT_MOVES';
}