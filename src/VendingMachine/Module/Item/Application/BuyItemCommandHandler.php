<?php

namespace App\VendingMachine\Module\Item\Application;

use App\VendingMachine\Module\Item\Domain\Exception\ItemNotFoundException;
use App\VendingMachine\Module\Item\Domain\Item;
use App\VendingMachine\Module\Item\Domain\ItemRepository;
use App\VendingMachine\Shared\Item\ItemName;

class BuyItemCommandHandler
{
    private $buyer;
    private $repository;

    public function __construct(BuyerService $buyer, ItemRepository $itemRepository)
    {
        $this->buyer = $buyer;
        $this->repository = $itemRepository;
    }

    public function __invoke(BuyItemCommand $command): BuyItemResponse
    {
        $itemName = new ItemName($command->itemName());
        $item = $this->repository->searchByName($itemName);
        $this->guarditem($item, $itemName);

        return ($this->buyer)($item);
    }

    private function guardItem(?Item $item, ItemName $itemName): void
    {
        if (null === $item || 0 === $item->stock()) {
            throw new ItemNotFoundException($itemName);
        }
    }


}