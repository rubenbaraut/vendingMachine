<?php

namespace App\VendingMachine\Module\Money\Domain;

interface CoinRepository
{
    public function save(Coin $coin): void;

    public function totalCoins(): ?Coins;

    public function removeAll(): ?Coins;
}