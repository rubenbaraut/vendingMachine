<?php

namespace App\Tests\Stub;

use App\VendingMachine\Shared\Item\ItemName;

final class ItemNameStub
{
    public static function create($name)
    {
        return new ItemName($name);
    }

    public static function random()
    {
        return self::create(StubCreator::random()->word);
    }
}
