<?php

namespace Opmvpc\BrainfuckPhp;

class BrainFuck
{
    private string $content;
    private int $contentCursor;
    private int $cellCursor;
    private array $stack;
    private \SplFixedArray $cells;

    public function __construct(string $path)
    {
        $this->content = FileReader::read($path);
        $this->contentCursor = 0;
        $this->cellCursor = 0;
        $this->stack = [];
        $this->cells = $this->newFixedArray();
    }

    public function start(): void
    {
        $time_start = microtime(true);

        while ($this->contentCursor < strlen($this->content)) {
            $char = $this->content[$this->contentCursor];

            try {
                match ($char) {
                    '>' => $this->incrementDataPointer(),
                    '<' => $this->decrementDataPointer(),
                    '+' => $this->incrementCell(),
                    '-' => $this->decrementCell(),
                    '.' => $this->outputCell(),
                    ',' => $this->inputCell(),
                    '[' => $this->openBracket(),
                    ']' => $this->closeBracket(),
                };
            } catch (\Throwable $th) {
            }

            ++$this->contentCursor;
        }

        $time_end = microtime(true);
        $time = $time_end - $time_start;
        echo "{$time}";
    }

    private function newFixedArray(): \SplFixedArray
    {
        $length = 30000;
        $array = new \SplFixedArray($length);

        for ($i = 0; $i < $length; ++$i) {
            $array[$i] = 0;
        }

        return $array;
    }

    private function incrementDataPointer(): void
    {
        ++$this->cellCursor;
    }

    private function decrementDataPointer(): void
    {
        --$this->cellCursor;
    }

    private function incrementCell(): void
    {
        $this->cells[$this->cellCursor] = $this->cells[$this->cellCursor] + 1;
    }

    private function decrementCell(): void
    {
        $this->cells[$this->cellCursor] = $this->cells[$this->cellCursor] - 1;
    }

    private function outputCell(): void
    {
        printf('%c', $this->cells[$this->cellCursor]);
    }

    private function openBracket(): void
    {
        if (0 === $this->cells[$this->cellCursor]) {
            $openInnerBracketCount = 1;

            while (0 !== $openInnerBracketCount) {
                ++$this->contentCursor;

                if ('[' === $this->content[$this->contentCursor]) {
                    ++$openInnerBracketCount;
                }

                if (']' === $this->content[$this->contentCursor]) {
                    --$openInnerBracketCount;
                }
            }
        } else {
            $this->stack[] = $this->contentCursor;
        }
    }

    private function closeBracket(): void
    {
        if (0 === $this->cells[$this->cellCursor]) {
            array_pop($this->stack);
        } else {
            $this->contentCursor = $this->stack[count($this->stack) - 1];
        }
    }

    private function inputCell(): void
    {
        $input = readline("Input a character : \n");
        $this->cells[$this->cellCursor] = ord($input);
    }
}
