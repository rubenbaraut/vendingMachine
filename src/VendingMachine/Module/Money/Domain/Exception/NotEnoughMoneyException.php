<?php

namespace App\VendingMachine\Module\Money\Domain\Exception;

use DomainException;

class NotEnoughMoneyException extends DomainException
{
    public function errorCode(): string
    {
        return 'not_enough_coin';
    }

    public function errorMessage(): string
    {
        return "You don't have enough money to buy this item, Insert coin";
    }
}