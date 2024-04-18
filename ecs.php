<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $config): void {
    $config->sets([
        SetList::ARRAY,
        SetList::CLEAN_CODE,
        SetList::PSR_12,
        SetList::SPACES,
        SetList::STRICT,
    ]);

    $config->paths([
        __DIR__ . '/src',
    ]);
};
