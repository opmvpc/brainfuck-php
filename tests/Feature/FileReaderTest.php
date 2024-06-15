<?php

use Opmvpc\BrainfuckPhp\FileReader;

test('can read file', function () {
    $content = FileReader::read('tests/Fixtures/simple.bf');
    expect($content)->toBe(
        <<<'EOF'
    [->+<]

    EOF
    );
});
