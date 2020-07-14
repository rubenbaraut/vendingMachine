<?php

namespace App\Tests\Stub;

final class StringStub
{
    public static function create(string $value)
    {
        return $value;
    }
    public static function random()
    {
        return StubCreator::random()->word;
    }
}
