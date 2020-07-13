<?php

namespace App\VendingMachine\Types\ValueObject;

abstract class StringValueObject
{
    protected $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value();
    }

    public function equals(StringValueObject $object): bool
    {
        return $this->value() === $object->value();
    }
}
