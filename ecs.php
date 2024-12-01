<?php

declare(strict_types=1);

ini_set('memory_limit', '3G');

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $config): void {
    $config->parallel();
    $config->import(SetList::PSR_12);
    $config->import(SetList::ARRAY);
    $config->import(SetList::CLEAN_CODE);
    $config->import(SetList::DOCTRINE_ANNOTATIONS);
    $config->import(SetList::NAMESPACES);
    $config->import(SetList::SPACES);

    $config->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);
    $config->skip([
        __DIR__ . '/phpstan-baseline.php',
    ]);
    $config->cacheDirectory('var/cache/ecs');
    $config->fileExtensions(['php']);

    // Limit parallel analysis when running on Gitlab CI
    if (isset($_ENV['CI'])) {
        $config->parallel(600, 4, 50);
    }
};
