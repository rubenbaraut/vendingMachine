<?php

namespace App\VendingMachine\Module\Money\Domain;

use App\VendingMachine\Types\Collection;
use function Lambdish\Phunctional\map;

class CoinsStocks extends Collection
{
    protected function type(): string
    {
        return CoinStock::class;
    }

    public static function fromArray(array $values)
    {
        return new self(map(self::creator(), $values));
    }

    private static function creator()
    {
        return function ($value, $key) {
            return new CoinStock($value, $key);
        };
    }
}