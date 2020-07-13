<?php

namespace App\VendingMachine\Module\Item\Domain;

use App\VendingMachine\Shared\Item\ItemId;

interface ItemRepository
{
    public function search(ItemId $itemId): ?Item;

    public function save(Item $item): void;
}