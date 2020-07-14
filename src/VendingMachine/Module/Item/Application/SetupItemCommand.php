<?php

namespace App\VendingMachine\Module\Item\Application;

class SetupItemCommand
{
    private $itemId;
    private $name;
    private $numberItems;
    private $price;

    public function __construct(string $itemId, string $name,float $price, int $numberItems)
    {
        $this->itemId = $itemId;
        $this->name = $name;
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

    public function name(): string
    {
        return $this->name;
    }
}