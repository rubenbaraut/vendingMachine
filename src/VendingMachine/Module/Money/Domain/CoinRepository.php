<?php

namespace App\VendingMachine\Module\Money\Domain;

interface CoinRepository
{
    public function save(Coin $coin): void;

    public function total(): float;

    public function removeAll(): ?Coins;
}