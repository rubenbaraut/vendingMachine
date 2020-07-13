<?php

namespace App\Tests\Stub;

use App\VendingMachine\Module\Item\Domain\Item;

final class ItemStub
{
    public static function create($id, $price, $stock)
    {
        return new Item($id, $price, $stock);
    }

    public static function random()
    {
        return self::create(
            ItemIdStub::random(),
            NumberStub::float(2),
            NumberStub::lessThan(10)
        );
    }
}
