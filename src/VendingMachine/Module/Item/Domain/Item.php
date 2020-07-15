<?php

namespace App\VendingMachine\Module\Item\Domain;

use App\VendingMachine\Shared\Item\ItemId;
use App\VendingMachine\Shared\Item\ItemName;

class Item
{
    private $itemId;
    private $name;
    private $stock;
    private $price;

    public function __construct(ItemId $itemId, ItemName $name, float $price, int $stock)
    {
        $this->itemId = $itemId;
        $this->name = $name;
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

    public function name(): ItemName
    {
        return $this->name;
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

    public function changeName(ItemName $name): void
    {
        if ($this->name->value() !== $name->value()) {
            $this->name = $name;
        }
    }

    public function equals(Item $item): bool
    {
        return $this->itemId->value() === $item->itemId->value() && $this->price === $item->price() && $this->stock === $item->stock() && $this->name->value() === $item->name()->value();
    }

    public function decreaseStock(): void
    {
        $this->changeStock($this->stock - 1);
    }

    public function buy(): void
    {
        $this->decreaseStock();
    }
}