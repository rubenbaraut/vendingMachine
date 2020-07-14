<?php

namespace App\VendingMachine\Module\Money\Domain;

use App\VendingMachine\Types\Collection;
use function Lambdish\Phunctional\map;

class Coins extends Collection
{
    protected function type(): string
    {
        return Coin::class;
    }

    public static function fromArray(array $values)
    {
        return new self(map(self::creator(), $values));
    }

    private static function creator()
    {
        return function (float $value) {
            return new Coin($value);
        };
    }

    public function toArray(): array
    {
        $data = [];
        foreach ($this->items as $key => $coin) {
            $data[] = $coin->value();
        }

        return $data;
    }

    public function total(): float
    {
        $total = 0;
        foreach ($this->items as $key => $coin) {
            $total += $coin->value();
        }

        return $total;
    }
}