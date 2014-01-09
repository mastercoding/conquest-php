<?php

namespace Mastercoding\Conquest\Move;

abstract class AbstractMove implements MoveInterface
{

    /**
     * The player who's making this move
     *
     * @var string
     */
    private $playerName;

    /**
     * Set the player who's making this move
     *
     * @param \Mastercoding\Conquest\Object\Owner\Player $player
     */
    public function setPlayerName($playerName)
    {
        $this->playerName = $playerName;
        return $this;
    }

    /**
     * Get the player who's making this move
     *
     * @return string
     */
    public function getPlayerName()
    {
        return $this->playerName;
    }

    /**
     * Expand (replace) {{player_name}} with actual player name
     *
     * @param string $string
     * @return string
     */
    public function expandPlayerName($string)
    {
        return str_replace('{{player_name}}', $this->getPlayerName(), $string);
    }

}