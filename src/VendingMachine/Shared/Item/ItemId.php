<?php
namespace App\VendingMachine\Shared\Item;

use App\VendingMachine\Types\ValueObject\StringValueObject;

final class ItemId extends StringValueObject
{
    public function isEquals(string $other)
    {
        return $this->value() === $other;
    }
}
