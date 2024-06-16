<?php

function executeBrainfuck($filePath)
{
    $startTime = \microtime(true);

    // Lire le fichier
    $code = \file_get_contents($filePath);
    if (false === $code) {
        exit('Erreur de lecture du fichier.');
    }

    // Initialiser la mémoire et les pointeurs
    $memory = \array_fill(0, 30000, 0);
    $pointer = 0;
    $codeLength = \strlen($code);
    $codePointer = 0;

    // Préparer une pile pour gérer les crochets
    $bracketStack = [];

    // Traiter chaque caractère du code
    while ($codePointer < $codeLength) {
        switch ($code[$codePointer]) {
            case '>':
                $pointer++;
                if ($pointer >= 30000) {
                    $pointer = 0;
                }

                break;

            case '<':
                $pointer--;
                if ($pointer < 0) {
                    $pointer = 29999;
                }

                break;

            case '+':
                $memory[$pointer]++;
                if ($memory[$pointer] > 255) {
                    $memory[$pointer] = 0;
                }

                break;

            case '-':
                $memory[$pointer]--;
                if ($memory[$pointer] < 0) {
                    $memory[$pointer] = 255;
                }

                break;

            case '.':
                echo \chr($memory[$pointer]);

                break;

            case ',':
                $memory[$pointer] = \ord(\fgetc(STDIN));

                break;

            case '[':
                if (0 == $memory[$pointer]) {
                    $loop = 1;
                    while ($loop > 0) {
                        ++$codePointer;
                        if ('[' == $code[$codePointer]) {
                            ++$loop;
                        }
                        if (']' == $code[$codePointer]) {
                            --$loop;
                        }
                    }
                } else {
                    \array_push($bracketStack, $codePointer);
                }

                break;

            case ']':
                if (0 != $memory[$pointer]) {
                    $codePointer = $bracketStack[\count($bracketStack) - 1];
                } else {
                    \array_pop($bracketStack);
                }

                break;
        }
        ++$codePointer;
    }

    $endTime = \microtime(true);
    $executionTime = $endTime - $startTime;
    echo "\nTemps d'exécution : ".$executionTime." secondes.\n";
}

if (2 != $argc) {
    exit("Usage: php brainfuck.php <chemin_du_fichier>\n");
}

$filePath = $argv[1];
executeBrainfuck($filePath);
