<?php

namespace App\VendingMachine\Module\Item\Application;

final class BuyItemResponse
{
    private $itemId;
    private $change;

    public function __construct(string $itemId, array $change)
    {
        $this->itemId = $itemId;
        $this->change = $change;
    }

    public function itemId(): string
    {
        return $this->itemId;
    }

    public function change(): array
    {
        return $this->change;
    }
}
