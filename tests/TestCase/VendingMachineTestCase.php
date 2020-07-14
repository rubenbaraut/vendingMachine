<?php

namespace App\Tests\TestCase;


use App\VendingMachine\Module\Item\Domain\Item;
use App\VendingMachine\Module\Item\Domain\ItemRepository;
use App\VendingMachine\Module\Money\Domain\Coin;
use App\VendingMachine\Module\Money\Domain\CoinRepository;
use App\VendingMachine\Module\Money\Domain\Coins;
use App\VendingMachine\Module\Money\Domain\CoinsStocks;
use App\VendingMachine\Module\Money\Domain\CoinStock;
use App\VendingMachine\Module\Money\Domain\CoinStockRepository;
use App\VendingMachine\Shared\Item\ItemId;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;


abstract class VendingMachineTestCase extends TestCase
{
    private $itemRepository;
    private $coinRepository;
    private $coinStockRepository;

    /** @return ItemRepository|MockInterface */
    protected function itemRepository()
    {
        return $this->itemRepository = $this->itemRepository ?: Mockery::mock(ItemRepository::class);
    }

    /** @return CoinRepository|MockInterface */
    protected function coinRepository()
    {
        return $this->coinRepository = $this->coinRepository ?: Mockery::mock(CoinRepository::class);
    }

    /** @return CoinStockRepository|MockInterface */
    protected function coinStockRepository()
    {
        return $this->coinStockRepository = $this->coinStockRepository ?: Mockery::mock(CoinStockRepository::class);
    }


    public function shouldSaveCoins(Coin $coin): void
    {
        $this->coinRepository()
            ->shouldReceive('save')
            ->with(Mockery::on(function ($argument) use ($coin) {
                return $coin->equals($argument);
            }))
            ->andReturnNull();
    }

    public function shouldSaveCoinStock(CoinStock $coinStock): void
    {
        $this->coinStockRepository()
            ->shouldReceive('save')
            ->with(Mockery::on(function (CoinStock $argument) use ($coinStock) {
                return $coinStock->quantity() === $argument->quantity() && $coinStock->coin()->value() === $argument->coin()->value();
            }))
            ->andReturnNull();
    }

    public function shouldFindAllCoinStockOrderedByValue(?CoinsStocks $coinStock = null)
    {
        $this->coinStockRepository()
            ->shouldReceive('findAllOrderedByValue')
            ->andReturn($coinStock);
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

    public function shouldRemoveCoins(?Coins $coins = null): void
    {
        $this->coinRepository()
            ->shouldReceive('removeAll')
            ->andReturn($coins);
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

    public function shouldSearchCoinStockWithValue(float $value, ?CoinStock $coinStock = null)
    {
        $this->coinStockRepository()
            ->shouldReceive('findByValue')
            ->with(Mockery::on(function ($argument) use ($value) {
                return $value === $argument;
            }))
            ->andReturn($coinStock);
    }

    public function shouldCalculateTotalCoins(float $total)
    {
        $this->coinRepository()
            ->shouldReceive('total')
            ->andReturn($total);
    }
}