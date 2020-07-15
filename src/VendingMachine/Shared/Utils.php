<?php

declare(strict_types = 1);

namespace App\VendingMachine\Shared;

use DateTimeImmutable;
use DateTimeInterface;
use RuntimeException;
use function Lambdish\Phunctional\filter;

final class Utils
{
    public static function toCamelCase(string $text): string
    {
        return lcfirst(str_replace('_', '', ucwords($text, '_')));
    }
}
