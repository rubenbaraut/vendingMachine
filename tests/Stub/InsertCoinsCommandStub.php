<?php

namespace App\Tests\Stub;

use App\VendingMachine\Module\Money\Application\InsertCoinsCommand;

final class InsertCoinsCommandStub
{
    public static function create(array $coins)
    {
        return new InsertCoinsCommand($coins);
    }

    public static function random()
    {
        $coins = CoinsStub::random();

        return self::create($coins->toArray());
    }
}
