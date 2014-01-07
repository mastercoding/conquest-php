<?php
// Execute this file: __main__

// the autoloader
require_once ('vendor/autoload.php');

// bot
$bot = new \Mastercoding\Conquest\Bot\StrategicBot();

// set strategies for this bot
$bot->setRegionPickerStrategy(new \Mastercoding\Conquest\Bot\Strategy\RegionPicker\Random());
$bot->setAttackTransferStrategy(new \Mastercoding\Conquest\Bot\Strategy\AttackTransfer\NoMoves());
$bot->setArmyPlacementStrategy(new \Mastercoding\Conquest\Bot\Strategy\ArmyPlacement\AllOnOne());

// run
$bot->run(STDIN, STDOUT);