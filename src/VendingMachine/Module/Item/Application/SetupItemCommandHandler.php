<?php

namespace App\VendingMachine\Module\Item\Application;

use App\VendingMachine\Shared\Item\ItemId;

class SetupItemCommandHandler
{
    private $adder;
    private $searcher;
    private $updater;

    public function __construct(ItemAdder $adder, ItemSearcher $searcher, ItemUpdater $updater)
    {
        $this->searcher = $searcher;
        $this->adder = $adder;
        $this->updater = $updater;
    }

    public function __invoke(SetupItemCommand $command): void
    {
        $itemId = new ItemId($command->itemId());
        $itemName = new ItemId($command->name());
        $item = ($this->searcher)($itemId);
        if (null == $item) {
            ($this->adder)($itemId, $itemName, $command->price(), $command->numberItems());
        } else {
            ($this->updater)($item, $itemName, $command->price(), $command->numberItems());
        }

        //falta  try catch al controller ItemNotFound
    }
}