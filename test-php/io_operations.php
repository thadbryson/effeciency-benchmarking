<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Stopwatch\Stopwatch;

// Set the # of array elements to the max PHP integer.
const LOOP_COUNT = 30000000;

function calcIf($bit, $against) {

    if ($bit === 0) {
        return 0;
    }

    return $bit;
}

function calcMultiply($bit, $against) {

    return $bit * $against;
}

$stopwatch = new Stopwatch();

$stopwatch->start('if');

// Test print function.
for ($against = 0;$against < LOOP_COUNT;$against++) {

    $bit = $against % 2;

    calcIf($bit, $against);
}

$eventIf = $stopwatch->stop('if');

$stopwatch->start('multiply');

// Test print function.
for ($against = 0;$against < LOOP_COUNT;$against++) {

    $bit = $against % 2;

    calcMultiply($bit, $against);
}

$eventMultiply = $stopwatch->stop('multiply');

const COLUMN_WIDTH = 30;

echo "\n\nLoop Performance: foreach() vs while() vs for()\n\n";
echo "We are using an array with ".LOOP_COUNT." elements.\n\n";
echo "----- Results -----\n";

echo str_pad('using if:',    COLUMN_WIDTH, ' ').$eventIf->getDuration()."ms\n";
echo str_pad('multiplying:', COLUMN_WIDTH, ' ').$eventMultiply->getDuration()."ms\n";
echo "\n";
