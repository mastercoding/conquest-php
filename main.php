<?php
// Execute this file: __main__

// the autoloader
require_once ('vendor/autoload.php');

$pr = new \SplPriorityQueue;
$pr->insert(25, 1);
$pr->insert(30, 2);
foreach ($pr as $d ) {
    echo $d;   
}
echo '<br />';
foreach ($pr as $d ) {
    echo $d;   
}
die;

// construct
$map = new \Mastercoding\Conquest\Object\Map();
$eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();

// bot
$bot = new \Helpless\Bot\FirstBot($map, $eventDispatcher);

// run
$bot->run(STDIN, STDOUT);