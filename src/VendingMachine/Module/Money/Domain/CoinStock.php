<?php

namespace App\VendingMachine\Module\Money\Domain;

class CoinStock
{
    private $quantity;
    private $coin;

    public function __construct(int $quantity, Coin $coin)
    {
        $this->quantity = $quantity;
        $this->coin = $coin;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function coin(): Coin
    {
        return $this->coin;
    }

    public function increment(): void
    {
        $this->quantity = $this->quantity + 1;
    }

    public function decrement()
    {
        if ($this->quantity > 0) {
            $this->quantity = $this->quantity - 1;
        }
    }
}