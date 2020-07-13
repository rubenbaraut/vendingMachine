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
        $item = ($this->searcher)($itemId);
        if (null == $item) {
            ($this->adder)($itemId, $command->price(), $command->numberItems());
        } else {
            ($this->updater)($item, $command->price(), $command->numberItems());
        }

        //falta  try catch al controller ItemNotFound
    }
}