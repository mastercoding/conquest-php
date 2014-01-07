<?php

interface BotInterface
{
    /**
     * Process the incomming command
     *
     * @param \Mastercoding\Conquest\Command $command
     */
    public function processCommand(\Mastercoding\Conquest\Command $command);

    /**
     * Get the moves for this round
     *
     * @return Array
     */
    public function getMoves();

}