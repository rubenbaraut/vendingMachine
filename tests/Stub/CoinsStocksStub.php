<?php

namespace App\Tests\Stub;

use App\VendingMachine\Module\Money\Domain\CoinsStocks;
use App\VendingMachine\Module\Money\Domain\CoinStock;
use function Lambdish\Phunctional\map;

final class CoinsStocksStub
{
    public static function create(CoinStock ...$coinStock): CoinsStocks
    {
        return new CoinsStocks($coinStock);
    }

    public static function fromValues(array $values): CoinsStocks
    {
        return new CoinsStocks(map(self::creator(), $values));
    }

    public static function random(int $count = null): CoinsStocks
    {
        return self::create(
            ...
            $count ? RepeatStub::repeat(self::randomCreator(), $count) : RepeatStub::random(self::randomCreator())
        );
    }

    private static function creator(): callable
    {
        return function ($coin, $key) {
            return new CoinStock($coin, $key);
        };
    }

    private static function randomCreator(): callable
    {
        return function () {
            return CoinStockStub::random();
        };
    }
}
