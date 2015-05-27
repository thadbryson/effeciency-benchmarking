<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Stopwatch\Stopwatch;

// Set the # of array elements to the max PHP integer.
const LOOP_COUNT = 10000000;

// Set max memeory size to a larger number. Default is 32 bytes.
// Changing to: 1024 MB, also equal to 1 GB
ini_set('memory_limit', '4096M');

// Get the big array.
$arrayLarge = require_once __DIR__.'/fixtures/array_large.php';

$stopwatch = new Stopwatch();

/**
 * Test foreach() loop iteration times.
 */
$stopwatch->start('foreach');

foreach ($arrayLarge as $key => $curr) {}

$eventForeach = $stopwatch->stop('foreach');

/**
 * Test while() loop iteration times.
 */
$stopwatch->start('while');

while (list($key, $curr) = each($arrayLarge)) {}

// Need to reset() the array or else it will be at the beginning.
reset($arrayLarge);

$eventWhile = $stopwatch->stop('while');

/**
 * Test while() and not assign $key and $curr values loop iteration times.
 */
$stopwatch->start('while-not');

while (each($arrayLarge)) {}

// Need to reset() the array or else it will be at the beginning.
reset($arrayLarge);

$eventWhileNot = $stopwatch->stop('while-not');

/**
 * Test for() loop iteration times.
 */
$stopwatch->start('for');

for ($i = 0;$i < LOOP_COUNT;$i++) {
    list($key, $curr) = each($arrayLarge);
}

// Need to reset() the array or else it will be at the beginning.
reset($arrayLarge);

$eventFor = $stopwatch->stop('for');

$stopwatch->start('for-not');

for ($i = 0;$i < LOOP_COUNT;$i++) {
    each($arrayLarge);
}

// Need to reset() the array or else it will be at the beginning.
reset($arrayLarge);

$eventForNot = $stopwatch->stop('for-not');

const COLUMN_WIDTH = 30;

echo "\n\nLoop Performance: foreach() vs while() vs for()\n\n";
echo "We are using an array with ".LOOP_COUNT." elements.\n\n";
echo "----- Results -----\n";

echo str_pad('foreach():', COLUMN_WIDTH, ' ')               .$eventForeach->getDuration()."ms\n";
echo str_pad('while():', COLUMN_WIDTH, ' ')                 .$eventWhile->getDuration()."ms\n";
echo str_pad('while() - no assign:', COLUMN_WIDTH, ' ')     .$eventWhileNot->getDuration()."ms\n";
echo str_pad('for():', COLUMN_WIDTH, ' ')                   .$eventFor->getDuration()."ms\n";
echo str_pad('for() - no assign:', COLUMN_WIDTH, ' ')       .$eventForNot->getDuration()."ms\n";
echo "\n";
