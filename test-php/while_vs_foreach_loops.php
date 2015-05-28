<?php

require_once __DIR__.'/../vendor/autoload.php';

use TCB\Benchmarker\Suite;
use TCB\Benchmarker\Test;

$test1 = function ($fixtures) {
    $fixtureArray = $fixtures[0];

    foreach ($fixtureArray as $key => $curr) {}
};

$test2 = function ($fixtures) {
    $fixtureArray = $fixtures[0];

    while (list($key, $curr) = each($fixtureArray)) {}
};

$test3 = function ($fixtures) {
    $fixtureArray = $fixtures[0];

    while (each($fixtureArray)) {}
};

$test4 = function ($fixtures) {
    $fixtureArray = $fixtures[0];

    for ($i = 0;$i < LOOP_SIZE;$i++) { list($key, $curr) = each($fixtureArray); }
};

$test5 = function ($fixtures) {
    $fixtureArray = $fixtures[0];

    for ($i = 0;$i < LOOP_SIZE;$i++) { each($fixtureArray); }
};

// Fix an array with LOOP_SIZE number of elements all of value 0.
const LOOP_SIZE = 10000000;

$fixtureArray = array_fill(0, LOOP_SIZE, 0);

$suite = new Suite('Loop Testing', 'See what loop is fastest. foreach() vs while() vs for()', [$fixtureArray]);

$test1 = new Test($test1, 'foreach()',                               "foreach (\$fixtureArray as \$key => \$curr) {}");
$test2 = new Test($test2, 'while()',                                 "while (list(\$key, \$curr) = each(\$fixtureArray)) {}");
$test3 = new Test($test3, 'while() without setting $key => $value',  "while (each(\$fixtureArray)) {}");
$test4 = new Test($test4, 'for()',                                   "for (\$i = 0;\$i < LOOP_SIZE;\$i++) { list(\$key, \$curr) = each(\$fixtureArray); }");
$test5 = new Test($test5, 'for() without setting $key => $value',    "for (\$i = 0;\$i < LOOP_SIZE;\$i++) { each(\$fixtureArray); }");

$suite
    ->addTest($test1)
    ->addTest($test2)
    ->addTest($test3)
    ->addTest($test4)
    ->addTest($test5)
;

$suite->run();
