<?php

namespace App\VendingMachine\Module\Money\Application;

use App\VendingMachine\Module\Money\Domain\Coins;

class ReturnCoinsCommandHandler
{
    private $coinsRemover;

    public function __construct(CoinsRemover $coinsRemover)
    {
        $this->coinsRemover = $coinsRemover;
    }

    public function __invoke(ReturnCoinsCommand $command): Coins
    {
        return ($this->coinsRemover)();
    }
}