<?php

namespace App\Tests\Stub;

use App\VendingMachine\Module\Item\Application\SetupItemCommand;
use App\VendingMachine\Shared\Item\ItemId;
use App\VendingMachine\Shared\Item\ItemName;

final class SetupItemCommandStub
{
    public static function create(ItemId $itemId, ItemName $name, float $price, int $numberItems): SetupItemCommand
    {
        return new SetupItemCommand($itemId, $name, $price, $numberItems);
    }

    public static function random(): SetupItemCommand
    {
        $itemId = ItemIdStub::random();
        $name = ItemNameStub::random();
        $price = NumberStub::float(2);
        $numberItems = NumberStub::lessThan(10);

        return self::create($itemId, $name, $price, $numberItems);
    }
}
