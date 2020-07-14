<?php

namespace App\VendingMachine\Module\Item\Application;

use App\VendingMachine\Module\Item\Domain\Item;
use App\VendingMachine\Module\Item\Domain\ItemRepository;
use App\VendingMachine\Shared\Item\ItemId;

class ItemAdder
{
    private $repository;

    public function __construct(ItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ItemId $itemId, string $name, float $price, int $numberItems): void
    {
        $item = new Item($itemId, $name, $price, $numberItems);
        $this->repository->save($item);
    }
}