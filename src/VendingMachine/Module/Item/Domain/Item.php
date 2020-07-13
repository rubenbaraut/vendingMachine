<?php

namespace App\VendingMachine\Module\Item\Domain;

use App\VendingMachine\Shared\Item\ItemId;

class Item
{
    private $itemId;
    private $stock;
    private $price;

    public function __construct(ItemId $itemId, float $price, int $stock)
    {
        $this->itemId = $itemId;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function itemId(): ItemId
    {
        return $this->itemId;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function stock(): int
    {
        return $this->stock;
    }

    public function changeStock(int $numberItems): void
    {
        if ($this->stock !== $numberItems) {
            $this->stock = $numberItems;
        }
    }

    public function changePrice(float $newPrice): void
    {
        if ($this->price !== $newPrice) {
            $this->price = $newPrice;
        }
    }

    public function equals(Item $item): bool
    {
        return $this->itemId->value() === $item->itemId->value() && $this->price === $item->price && $this->stock === $item->stock;
    }

    public function decreaseStock(): void
    {
        $this->changeStock($this->stock - 1);
    }
}