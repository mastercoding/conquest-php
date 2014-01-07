<?php

namespace Mastercoding\Conquest\Command;

class SettingParser implements \Mastercoding\Conquest\Command\Parser\ParserInterface
{

    /**
     * @inheritDoc
     */
    public function parse($line)
    {

        // seperate components
        $components = explode(' ', $line);

        // parse setting name into input command
        switch ( $components[1] ) {

            case 'your_bot':
            case 'opponent_bot':
                return Settings\Player::create($components);

            case 'starting_armies':
                return Settings\StartingArmies::create($components);

            default:
                throw new \Exception('Unimplemented setting: ' . $components[1]);
        }

    }

}
