<?php

namespace App\VendingMachine\Module\Money\Domain\Service;

use App\VendingMachine\Module\Money\Domain\Coins;
use App\VendingMachine\Module\Money\Domain\CoinsStocks;
use App\VendingMachine\Module\Money\Domain\CoinStockRepository;
use App\VendingMachine\Module\Money\Domain\Exception\NoCoinStockException;

class ChangeCalculator
{
    private $coinStockRepository;

    public function __construct(CoinStockRepository $coinStockRepository)
    {
        $this->coinStockRepository = $coinStockRepository;
    }

    public function __invoke(float $import): Coins
    {
        $import = $import * 100;
        $coinsStocks = $this->coinStockRepository->findAllOrderedByValue();
        $this->guard($coinsStocks);
        $change = [];
        $counter = 0;

        while ($import > 0) {
            foreach ($coinsStocks->items() as $coinStock) {
                $filled = false;
                $coinStockValue = $coinStock->coin()->value() * 100;
                if ($import >= $coinStockValue && $coinStock->quantity() > 0) {
                    $import = $import - $coinStockValue;
                    $coinStock->decrement();
                    $change[] = $coinStockValue / 100;
                    $filled = true;
                    break;
                }
                if (!$filled && $counter === $coinsStocks->count()) {
                    throw new NoCoinStockException();
                }
            }
            $counter++;
        }

        return Coins::fromArray($change);
    }

    private function guard(?CoinsStocks $coinsStock): void
    {
        if (null === $coinsStock) {
            throw new NoCoinStockException();
        }
    }
}