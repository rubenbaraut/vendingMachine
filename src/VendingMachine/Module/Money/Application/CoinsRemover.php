<?php

namespace App\VendingMachine\Module\Money\Application;

use App\VendingMachine\Module\Money\Domain\CoinRepository;
use App\VendingMachine\Module\Money\Domain\Coins;
use App\VendingMachine\Module\Money\Domain\Exception\NoCoinException;

class CoinsRemover
{
    private $repository;

    public function __construct(CoinRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(): ?Coins
    {
        $coins = $this->repository->removeAll();
        $this->guard($coins);

        return $coins;
    }

    private function guard(?Coins $coins): void
    {
        if (null === $coins) {
            throw new NoCoinException();
        }
    }
}