<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Stopwatch\Stopwatch;

// Set the # of array elements to the max PHP integer.
const LOOP_COUNT = 1000000;

$stopwatch = new Stopwatch();

$stopwatch->start('print');

// Test print function.
for ($i = 0;$i < LOOP_COUNT;$i++) {
    print $i."\n";
}

$eventPrint = $stopwatch->stop('print');

$stopwatch->start('echo');

// Test echo function.
for ($i = 0;$i < LOOP_COUNT;$i++) {
    echo $i."\n";
}

$eventEcho = $stopwatch->stop('echo');

// Going to use Echo here though.
echo "\n\n----- print vs echo output -----\n\n";

echo LOOP_COUNT." iterations test\n";

const COLUMN_WIDTH = 30;

echo str_pad('print:', COLUMN_WIDTH, ' ').$eventPrint->getDuration()."ms\n";
echo str_pad('echo', COLUMN_WIDTH, ' ')  .$eventEcho->getDuration()."ms\n";
