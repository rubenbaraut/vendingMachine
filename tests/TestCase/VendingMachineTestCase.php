<?php

namespace App\Tests\TestCase;


use App\VendingMachine\Module\Item\Domain\Item;
use App\VendingMachine\Module\Item\Domain\ItemRepository;
use App\VendingMachine\Shared\Item\ItemId;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;


abstract class VendingMachineTestCase extends TestCase
{
    private $itemRepository;

    /** @return ItemRepository|MockInterface */
    protected function itemRepository()
    {
        return $this->itemRepository = $this->itemRepository ?: Mockery::mock(ItemRepository::class);
    }

    public function shouldSaveItem(Item $item): void
    {
        $this->itemRepository()
            ->shouldReceive('save')
            ->with(Mockery::on(function ($argument) use ($item) {
                return $item->equals($argument);
            }))
            ->andReturnNull();
    }

    public function shouldSearchItem(ItemId $itemId, ?Item $item = null)
    {
        $this->itemRepository()
            ->shouldReceive('search')
            ->with(Mockery::on(function ($argument) use ($itemId) {
                return $itemId->equals($argument);
            }))
            ->andReturn($item);
    }
}