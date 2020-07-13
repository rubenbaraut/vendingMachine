<?php

namespace App\VendingMachine\Module\Money\Application;

class InsertCoinsCommand
{
    private $coins;

    public function __construct(array $coins)
    {
        $this->coins = $coins;
    }

    public function coins(): array
    {
        return $this->coins;
    }
}