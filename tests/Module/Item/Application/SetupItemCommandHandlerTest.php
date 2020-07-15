<?php

namespace App\Tests;

use App\Tests\Stub\ItemIdStub;
use App\Tests\Stub\ItemNameStub;
use App\Tests\Stub\ItemStub;
use App\Tests\Stub\NumberStub;
use App\Tests\Stub\SetupItemCommandStub;
use App\Tests\TestCase\VendingMachineTestCase;
use App\VendingMachine\Module\Item\Application\ItemAdder;
use App\VendingMachine\Module\Item\Application\ItemUpdater;
use App\VendingMachine\Module\Item\Application\SetupItemCommandHandler;


class SetupItemCommandHandlerTest extends VendingMachineTestCase
{
    private $handler;

    public function setUp()
    {
        $adder = new ItemAdder($this->itemRepository());
        $updater = new ItemUpdater($this->itemRepository());
        $this->handler = new SetupItemCommandHandler($adder, $this->itemRepository(), $updater);
    }

    /** @test */
    public function should_add_item_if_item_not_exist()
    {
        $command = SetupItemCommandStub::random();
        $itemId = ItemIdStub::create($command->itemId());
        $itemName = ItemNameStub::create($command->name());
        $newItem = ItemStub::create($itemId,$itemName, $command->price(), $command->numberItems());
        $this->shouldSearchItem($itemId);
        $this->shouldSaveItem($newItem);
        ($this->handler)($command);
    }

    /** @test */
    public function should_update_item_if_item_exist()
    {
        $command = SetupItemCommandStub::random();
        $itemId = ItemIdStub::create($command->itemId());
        $itemName = ItemNameStub::create($command->name());
        $existingItem = ItemStub::create($itemId, $itemName, NumberStub::float(2), NumberStub::lessThan(5));
        $this->shouldSearchItem($itemId, $existingItem);
        $this->shouldSaveItem($existingItem);
        ($this->handler)($command);
    }
}