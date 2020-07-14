<?php

namespace App\VendingMachine\Module\Item\Application;

class BuyItemCommand
{
    private $itemId;

    public function __construct(string $itemId)
    {
        $this->itemId = $itemId;
    }

    public function itemId(): string
    {
        return $this->itemId;
    }
}