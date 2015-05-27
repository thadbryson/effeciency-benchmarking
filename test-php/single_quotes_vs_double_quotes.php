<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Stopwatch\Stopwatch;

// Set the # of array elements to the max PHP integer.
const LOOP_COUNT = 10000000;

$stopwatch = new Stopwatch();

$stopwatch->start('double');

for ($i = 0;$i < LOOP_COUNT;$i++) {
    $output = "i: ".$i;

    echo $output;
}

$eventDouble = $stopwatch->stop('double');

$stopwatch->start('single');

for ($i = 0;$i < LOOP_COUNT;$i++) {
    $output = 'i: '.$i;

    echo $output;
}

$eventSingle = $stopwatch->stop('single');

echo "\n\nQuote Performance: Single ' vs Double \"\n\n";
echo "----- Results -----\n";

const COLUMN_WIDTH = 30;

echo str_pad('double quotes ":',  COLUMN_WIDTH, ' ').$eventDouble->getDuration()."ms\n";
echo str_pad('single quotes \':', COLUMN_WIDTH, ' ').$eventSingle->getDuration()."ms\n";
echo "\n";
