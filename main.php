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
    $bot->processCommand($command);

    // get moves
    $moves = $bot->getMoves();

    // output moves
    \Mastercoding\Conquest\Output::moves($moves);

}