<?php

namespace App\VendingMachine\Module\Money\Application;

use App\VendingMachine\Module\Money\Domain\CoinRepository;
use App\VendingMachine\Module\Money\Domain\Coins;

class CoinsAdder
{
    private $repository;

    public function __construct(CoinRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Coins $coins): void
    {
        foreach ($coins->items() as $coin) {
            $this->repository->save($coin);
        }
    }
}