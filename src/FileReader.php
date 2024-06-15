<?php

namespace Opmvpc\BrainfuckPhp;

class FileReader
{
    public static function read(string $path): string
    {
        return file_get_contents(realpath($path));
    }
}
