<?php

namespace App\VendingMachine\Module\Money\Application;

use App\VendingMachine\Module\Money\Domain\Coins;

class InsertCoinsCommandHandler
{
    private $coinsAdder;

    public function __construct(CoinsAdder $coinsAdder)
    {
        $this->coinsAdder = $coinsAdder;
    }

    public function __invoke(InsertCoinsCommand $command): void
    {
        $coins = Coins::fromArray($command->coins());
        ($this->coinsAdder)($coins);
    }
}