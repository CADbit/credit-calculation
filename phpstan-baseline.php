<?php declare(strict_types=1);

$ignoreErrors = [
    [
        'message' => '#method\.nonObject#',
        'path' =>  __DIR__ . '/src/Credit/Domain/Services/*.php',
    ],
    [
        'message' => '#missingType\.iterableValue#',
        'path' =>  __DIR__ . '/src/Credit/Domain/Services/*.php'
    ],
    [
        'message' => '#property\.onlyRead#',
        'path' =>  __DIR__ . '/src/Credit/Domain/Entity/*.php',
    ],
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
