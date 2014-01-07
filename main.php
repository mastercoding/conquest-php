<?php
// Execute this file: __main__

// the autoloader
require_once ('vendor/autoload.php');

// setup parser
$commandParser = new Mastercoding\Conquest\Command\Parser\Parser();

// bot
$bot = new \Mastercoding\Conquest\Bot\SimpleBot();

// loop
while ($line = trim(fgets(STDIN))) {

    // parse command
    $command = $commandParser->parse($line);
    $move = $bot->processCommand($command);

    if (null !== $move) {

        // output moves
        \Mastercoding\Conquest\Output::move($bot, $move);

    }

}