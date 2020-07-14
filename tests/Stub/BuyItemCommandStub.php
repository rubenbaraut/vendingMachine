<?php

namespace App\Tests\Stub;

use App\VendingMachine\Module\Item\Application\BuyItemCommand;

use App\VendingMachine\Shared\Item\ItemId;

final class BuyItemCommandStub
{
    public static function create(ItemId $itemId): BuyItemCommand
    {
        return new BuyItemCommand($itemId);
    }

    public static function random(): BuyItemCommand
    {
        $itemId = ItemIdStub::random();
        return self::create($itemId);
    }
}
