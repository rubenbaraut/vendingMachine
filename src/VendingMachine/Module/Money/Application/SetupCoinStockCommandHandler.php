<?php

namespace App\VendingMachine\Module\Money\Application;

use App\VendingMachine\Module\Money\Domain\Coins;

class SetupCoinStockCommandHandler
{
    private $adder;

    public function __construct(CoinStockAdder $adder)
    {
        $this->adder = $adder;
    }

    public function __invoke(SetupCoinStockCommand $command): void
    {
        $coins = Coins::fromArray($command->coins());
        ($this->adder)($coins);
    }
}