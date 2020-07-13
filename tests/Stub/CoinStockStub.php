<?php

namespace App\Tests\Stub;

use App\VendingMachine\Module\Money\Domain\Coin;
use App\VendingMachine\Module\Money\Domain\CoinStock;

final class CoinStockStub
{
    public static function create($quantity, Coin $coin)
    {
        return new CoinStock($quantity, $coin);
    }

    public static function random()
    {
        $possibleCoins = array_values(Coin::values());
        $rand = mt_rand(0, count(Coin::values()) - 1);

        return self::create(NumberStub::lessThan(5), Coin::fromString($possibleCoins[$rand]));
    }
}
