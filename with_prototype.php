<?php

require_once 'Person.php';

function convertMemoryUsage($size)
{
    $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
    return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}

function bench(callable $callback, int $times)
{
    $executionTimes = [];
    for ($i = 0; $i < $times; $i++) {
        $start = microtime(true);
        $callback();
        $executionTimes[] = microtime(true) - $start;
    }

    $time = array_reduce($executionTimes, function ($carry, $item) {
        $carry += $item;
        return $carry;
    });
    echo $time / count($executionTimes);
}

bench(function () {
    $person = new Person();
    for ($i = 0; $i < 1000000; $i++) {
        $person = clone $person;
        $person->setName(str_shuffle('abcdefghijklmnopq'));
        $person->setEmail(str_shuffle('abcdefghijklmnopq'));
        $personList[] = $person;
    }

}, 100);

