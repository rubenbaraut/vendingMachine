<?php

namespace App\Tests\Stub;

use App\VendingMachine\Module\Item\Application\BuyItemCommand;

final class BuyItemCommandStub
{
    public static function create(string $itemName): BuyItemCommand
    {
        return new BuyItemCommand($itemName);
    }

    public static function random(): BuyItemCommand
    {
        $itemName = StringStub::random();
        return self::create($itemName);
    }
}
