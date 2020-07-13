<?php

namespace App\Tests\Stub;

use App\VendingMachine\Shared\Item\ItemId;

final class ItemIdStub
{
    public static function create($id)
    {
        return new ItemId($id);
    }

    public static function random()
    {
        return self::create(StubCreator::random()->uuid);
    }
}
