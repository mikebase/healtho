<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Application\Query;

interface GetAllProducts
{
    /**
     * @return array|Product[]
     */
    public function getResult(): array;
}
