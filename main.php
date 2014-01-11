<?php
// Execute this file: __main__

// the autoloader
require_once ('vendor/autoload.php');

// construct
$map = new \Mastercoding\Conquest\Object\Map();
$eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();

// bot
$bot = new \Helpless\Bot\FirstBot($map, $eventDispatcher);

// run
$commandParser = new \Mastercoding\Conquest\Command\Parser\Parser();
$bot->run($commandParser, STDIN, STDOUT);
