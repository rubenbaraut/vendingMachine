<?php

namespace App\VendingMachine\Module\Money\Domain;

use App\VendingMachine\Module\Money\Domain\Exception\InvalidCoinException;
use App\VendingMachine\Types\ValueObject\Enum;

/**
 * @method static Coin fiveCentsCoin()
 * @method static Coin fiftyCentsCoin()
 * @method static Coin twentyFiveCentsCoin()
 * @method static Coin oneCoin()
 */
class Coin extends Enum
{
    const FIVE_CENTS_COIN = 0.05;
    const FIFTY_CENTS_COIN = 0.10;
    const TWENTY_FIVE_CENTS_COIN = 0.25;
    const ONE_COIN = 1.0;

    protected function throwExceptionForInvalidValue($value)
    {
        throw new InvalidCoinException($value);
    }
}