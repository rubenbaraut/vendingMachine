<?php

namespace App\Tests\Stub;

use App\VendingMachine\Module\Money\Domain\Coin;
use App\VendingMachine\Module\Money\Domain\Coins;
use function Lambdish\Phunctional\map;

final class CoinsStub
{
    public static function create(Coin ...$coins): Coins
    {
        return new Coins($coins);
    }

    public static function fromValues(array $values): Coins
    {
        return new Coins(map(self::creator(), $values));
    }

    public static function random(int $count = null): Coins
    {
        return self::create(
            ...
            $count ? RepeatStub::repeat(self::randomCreator(), $count) : RepeatStub::random(self::randomCreator())
        );
    }

    private static function creator(): callable
    {
        return function ($coin) {
            return new Coin($coin);
        };
    }

    private static function randomCreator(): callable
    {
        return function () {
            return CoinStub::random();
        };
    }
}
