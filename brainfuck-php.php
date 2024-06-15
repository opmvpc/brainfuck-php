<?php

require __DIR__.'/vendor/autoload.php';

use Opmvpc\BrainfuckPhp\BrainFuck;

(new BrainFuck($argv[1]))->start();
