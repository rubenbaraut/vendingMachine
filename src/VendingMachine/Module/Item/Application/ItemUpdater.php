<?php

namespace App\VendingMachine\Module\Item\Application;

use App\VendingMachine\Module\Item\Domain\Item;
use App\VendingMachine\Module\Item\Domain\ItemRepository;

class ItemUpdater
{
    private $repository;

    public function __construct(ItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Item $item,string $name, float $price, int $numberItems): void
    {
        $item->changeName($name);
        $item->changePrice($price);
        $item->changeStock($numberItems);
        $this->repository->save($item);
    }
}