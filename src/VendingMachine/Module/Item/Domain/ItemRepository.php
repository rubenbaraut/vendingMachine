<?php

namespace App\VendingMachine\Module\Item\Domain;

use App\VendingMachine\Shared\Item\ItemId;
use App\VendingMachine\Shared\Item\ItemName;

interface ItemRepository
{
    public function search(ItemId $itemId): ?Item;

    public function save(Item $item): void;

    public function searchByName(ItemName $name): ?Item;
}