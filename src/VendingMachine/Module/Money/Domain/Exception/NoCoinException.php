<?php

namespace App\VendingMachine\Module\Money\Domain\Exception;

use DomainException;

class NoCoinException extends DomainException
{
    public function errorCode(): string
    {
        return 'no_coin';
    }

    public function errorMessage(): string
    {
        return 'No coins in the machine';
    }
}