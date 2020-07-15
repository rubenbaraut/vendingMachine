<?php

namespace App\VendingMachine\Module\Item\Application;

class BuyItemCommand
{
    private $itemName;

    public function __construct(string $itemName)
    {
        $this->itemName = $itemName;
    }

    public function itemName(): string
    {
        return $this->itemName;
    }
}