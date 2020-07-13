<?php

namespace App\Tests\Stub;

use App\VendingMachine\Module\Item\Application\SetupItemCommand;
use App\VendingMachine\Shared\Item\ItemId;

final class SetupItemCommandStub
{
    public static function create(ItemId $itemId, float $price, int $numberItems): SetupItemCommand
    {
        return new SetupItemCommand($itemId, $price, $numberItems);
    }

    public static function random(): SetupItemCommand
    {
        $itemId = ItemIdStub::random();
        $price = NumberStub::float(2);
        $numberItems = NumberStub::lessThan(10);

        return self::create($itemId, $price, $numberItems);
    }
}
