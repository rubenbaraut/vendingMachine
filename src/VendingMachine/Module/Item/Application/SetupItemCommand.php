<?php

namespace App\VendingMachine\Module\Item\Application;

class SetupItemCommand
{
    private $itemId;
    private $numberItems;
    private $price;

    public function __construct(string $itemId, float $price, int $numberItems)
    {
        $this->itemId = $itemId;
        $this->numberItems = $numberItems;
        $this->price = $price;
    }

    public function itemId(): string
    {
        return $this->itemId;
    }

    public function numberItems(): int
    {
        return $this->numberItems;
    }

    public function price(): float
    {
        return $this->price;
    }
}