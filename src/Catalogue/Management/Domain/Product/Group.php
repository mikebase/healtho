<?php

declare(strict_types=1);

namespace Healtho\Catalogue\Management\Domain\Product;

enum Group: string
{
    case FRUIT = 'Owoce';
    case VEGETABLE = 'Warzywa';
    case MEAT = 'Mięsa';
    case FISH = 'Ryby';
    case CARB = 'Węglowodany';
    case DAIRY = 'Nabiał';
    case FAT = 'Tłuszcze';
    case OTHER = 'Inne';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
