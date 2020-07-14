<?php

namespace App\VendingMachine\Module\Money\Domain\Exception;

use DomainException;

class NoCoinStockException extends DomainException
{
    public function errorCode(): string
    {
        return 'no_coin_stock';
    }

    public function errorMessage(): string
    {
        return 'No coins for change in the machine';
    }
}