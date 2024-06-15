<?php

use Opmvpc\BrainfuckPhp\BrainFuck;

test('simple program', function () {
    $result = (new BrainFuck('tests/Fixtures/simple.bf'))->start();

    expect($result)->toBe('');
});

test('maths', function () {
    $result = (new BrainFuck('tests/Fixtures/maths.bf'))->start();

    expect($result)->toBe('7');
});

test('hello world', function () {
    $result = (new BrainFuck('tests/Fixtures/hello_world.bf'))->start();

    expect($result)->toBe("Hello World!\n");
});

test('rot 13', function () {
    $result = (new BrainFuck('tests/Fixtures/ROT13.bf'))->start();

    expect($result)->toBe("Hello World!\n");
});
