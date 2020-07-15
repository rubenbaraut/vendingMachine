<?php

namespace App\VendingMachine\Module\Item\Application;

use App\VendingMachine\Module\Item\Domain\ItemRepository;
use App\VendingMachine\Shared\Item\ItemId;
use App\VendingMachine\Shared\Item\ItemName;

class SetupItemCommandHandler
{
    private $adder;
    private $repository;
    private $updater;

    public function __construct(ItemAdder $adder, ItemRepository $repository, ItemUpdater $updater)
    {
        $this->repository = $repository;
        $this->adder = $adder;
        $this->updater = $updater;
    }

    public function __invoke(SetupItemCommand $command): void
    {
        $itemId = new ItemId($command->itemId());
        $itemName = new ItemName($command->name());
        $item = $this->repository->search($itemId);

        if (null == $item) {
            ($this->adder)($itemId, $itemName, $command->price(), $command->numberItems());
        } else {
            ($this->updater)($item, $itemName, $command->price(), $command->numberItems());
        }
    }
}