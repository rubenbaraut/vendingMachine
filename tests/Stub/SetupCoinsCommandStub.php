<?php

namespace App\Tests\Stub;

use App\VendingMachine\Module\Money\Application\SetupCoinStockCommand;
use function Lambdish\Phunctional\instance_of;

final class SetupCoinsCommandStub
{
    public static function create(array $coins)
    {
        return new SetupCoinStockCommand($coins);
    }

    public static function random()
    {
        $coins = CoinsStub::random();

        return self::create($coins->toArray());
    }
}
