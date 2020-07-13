<?php

namespace App\Tests\Stub;

use App\VendingMachine\Module\Money\Domain\Coin;

final class CoinStub
{
    public static function create($value)
    {
        return new Coin($value);
    }

    public static function random()
    {
        $possibleCoins = array_values(Coin::values());
        $rand = mt_rand(0, count(Coin::values()) - 1);

        return Coin::fromString($possibleCoins[$rand]);
    }
}
