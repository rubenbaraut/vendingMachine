<?php

namespace App\Tests\Stub;

use App\VendingMachine\Module\Item\Application\SetupItemCommand;
use App\VendingMachine\Shared\Item\ItemId;

final class SetupItemCommandStub
{
    public static function create(ItemId $itemId, string $name, float $price, int $numberItems): SetupItemCommand
    {
        return new SetupItemCommand($itemId, $name, $price, $numberItems);
    }

    public static function random(): SetupItemCommand
    {
        $itemId = ItemIdStub::random();
        $name = StringStub::random();
        $price = NumberStub::float(2);
        $numberItems = NumberStub::lessThan(10);

        return self::create($itemId, $name, $price, $numberItems);
    }
}
