<?php

namespace App\VendingMachine\Module\Money\Domain\Exception;

use DomainException;

class InvalidCoinException extends DomainException
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid_coin_value';
    }

    public function errorMessage(): string
    {
        return sprintf('The coin with value %s is not a valid coin', $this->value);
    }
}