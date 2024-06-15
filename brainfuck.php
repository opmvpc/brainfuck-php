<?php

function start(string $path): void
{
    $content = \file_get_contents(\realpath($path));
    $contentCursor = 0;
    $cellCursor = 0;
    $stack = [];
    $cells = newFixedArray();
    $time_start = \microtime(true);

    while ($contentCursor < \strlen($content)) {
        $char = $content[$contentCursor];

        try {
            match ($char) {
                '>' => ++$cellCursor,
                '<' => --$cellCursor,
                '+' => $cells[$cellCursor]++,
                '-' => $cells[$cellCursor]--,
                '.' => \printf('%c', $cells[$cellCursor]),
                ',' => $cells[$cellCursor] = \ord(\readline("Input a character : \n")),
                '[' => openBracket($cells, $cellCursor, $stack, $contentCursor, $content),
                ']' => closeBracket($cells, $cellCursor, $stack, $contentCursor),
            };
        } catch (Throwable $th) {
        }

        ++$contentCursor;
    }

    $time_end = \microtime(true);
    $time = $time_end - $time_start;
    echo "{$time} secondes";
}

function newFixedArray(): array
{
    $length = 30000;
    $array = [];

    for ($i = 0; $i < $length; ++$i) {
        $array[$i] = 0;
    }

    return $array;
}

function openBracket(array $cells, int $cellCursor, array &$stack, int &$contentCursor, string $content): void
{
    if (0 === $cells[$cellCursor]) {
        $openInnerBracketCount = 1;

        while (0 !== $openInnerBracketCount) {
            ++$contentCursor;

            if ('[' === $content[$contentCursor]) {
                ++$openInnerBracketCount;
            }

            if (']' === $content[$contentCursor]) {
                --$openInnerBracketCount;
            }
        }
    } else {
        $stack[] = $contentCursor;
    }
}

function closeBracket(array $cells, int $cellCursor, array &$stack, int &$contentCursor): void
{
    if (0 === $cells[$cellCursor]) {
        \array_pop($stack);
    } else {
        $contentCursor = $stack[\count($stack) - 1];
    }
}

start($argv[1]);
