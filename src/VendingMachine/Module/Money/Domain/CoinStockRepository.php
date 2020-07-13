<?php

namespace App\VendingMachine\Module\Money\Domain;

interface CoinStockRepository
{
    public function save(CoinStock $coinBox): void;
    public function findByValue(float $value): ?CoinStock;
}