<?php

namespace App\VendingMachine\Module\Money\Application;

use App\VendingMachine\Module\Money\Domain\Coins;
use App\VendingMachine\Module\Money\Domain\CoinStock;
use App\VendingMachine\Module\Money\Domain\CoinStockRepository;

class CoinStockAdder
{
    private $repository;

    public function __construct(CoinStockRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Coins $coins): void
    {
        foreach ($coins->items() as $coin) {
            $coinStock = $this->repository->findByValue($coin->value());
            if (null === $coinStock) {
                $coinStock = new CoinStock(0, $coin);
            }
            $coinStock->increment();
            $this->repository->save($coinStock);
        }
    }
}