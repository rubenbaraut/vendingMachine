<?php

namespace App\Tests;

use App\Tests\Stub\BuyItemCommandStub;
use App\Tests\Stub\CoinsStocksStub;
use App\Tests\Stub\CoinsStub;
use App\Tests\Stub\CoinStockStub;
use App\Tests\Stub\CoinStub;
use App\Tests\Stub\ItemIdStub;
use App\Tests\Stub\ItemNameStub;
use App\Tests\Stub\ItemStub;
use App\Tests\TestCase\VendingMachineTestCase;
use App\VendingMachine\Module\Item\Application\BuyerService;
use App\VendingMachine\Module\Item\Application\BuyItemCommandHandler;
use App\VendingMachine\Module\Item\Domain\Exception\ItemNotFoundException;
use App\VendingMachine\Module\Money\Domain\Exception\NotEnoughMoneyException;
use App\VendingMachine\Module\Money\Domain\Service\ChangeCalculator;


class BuyItemCommandHandlerTest extends VendingMachineTestCase
{
    private $handler;

    public function setUp()
    {
        $changeCalculator = new ChangeCalculator($this->coinStockRepository());
        $buyer = new BuyerService(
            $this->coinRepository(),
            $this->itemRepository(),
            $changeCalculator
        );

        $this->handler = new BuyItemCommandHandler($buyer, $this->itemRepository());
    }

    /** @test */
    public function should_not_buy_item_if_item_not_exist()
    {
        $command = BuyItemCommandStub::random();
        $itemName = ItemNameStub::create($command->itemName());

        $this->shouldSearchItemByName($itemName);
        $this->expectException(ItemNotFoundException::class);
        ($this->handler)($command);
    }

    /** @test */
    public function should_not_buy_item_if_item_not_have_stock()
    {
        $command = BuyItemCommandStub::random();
        $itemId = ItemIdStub::random();
        $itemName = ItemNameStub::create($command->itemName());
        $item = ItemStub::create($itemId,$itemName, 10.0, 0);

        $this->shouldSearchItemByName($itemName, $item);
        $this->expectException(ItemNotFoundException::class);
        ($this->handler)($command);
    }

    /** @test */
    public function should_not_buy_item_if_coins_added_not_enough_to_buy()
    {
        $command = BuyItemCommandStub::random();
        $itemId = ItemIdStub::random();
        $itemName = ItemNameStub::create($command->itemName());
        $item = ItemStub::create($itemId,$itemName, 1.0, 10);
        $coins = CoinsStub::fromValues([0.05]);

        $this->shouldSearchItemByName($itemName, $item);
        $this->shouldCalculateTotalCoins($coins->total());
        $this->expectException(NotEnoughMoneyException::class);
        ($this->handler)($command);
    }

    /** @test */
    public function should_buy_item_if_enough_money_and_enough_stock_with_exact_price()
    {
        $command = BuyItemCommandStub::random();
        $itemId = ItemIdStub::random();
        $itemName = ItemNameStub::create($command->itemName());
        $item = ItemStub::create($itemId,$itemName, 1.0, 10);
        $itemToSave = ItemStub::create($itemId,$itemName, 1.0, 9);
        $coins = CoinsStub::fromValues([1.0]);

        $coinStocks1 = CoinStockStub::create(10,CoinStub::create(1.0));
        $coinStocks2 = CoinStockStub::create(10,CoinStub::create(0.25));
        $coinStocks3 = CoinStockStub::create(10,CoinStub::create(0.10));
        $coinStocks4 = CoinStockStub::create(10,CoinStub::create(0.05));

        $coinsStocksOrdered = CoinsStocksStub::create($coinStocks1,$coinStocks2,$coinStocks3,$coinStocks4);

        $this->shouldSearchItemByName($itemName, $item);
        $this->shouldCalculateTotalCoins($coins->total());
        $this->shouldSaveItem($itemToSave);
        $this->shouldFindAllCoinStockOrderedByValue($coinsStocksOrdered);

        $itemBuyed = ($this->handler)($command);
        $this->assertEquals($itemBuyed->itemId(), $itemId);
        $this->assertEquals($itemBuyed->change(), []);
    }

    /** @test */
    public function should_buy_item_if_enough_money_and_enough_stock_returning_change()
    {
        $command = BuyItemCommandStub::random();
        $itemId = ItemIdStub::random();
        $itemName = ItemNameStub::create($command->itemName());
        $item = ItemStub::create($itemId,$itemName, 1.0, 10);
        $itemToSave = ItemStub::create($itemId, $itemName,1.0, 9);
        $coins = CoinsStub::fromValues([1.0,0.25,0.25]);

        $coinStocks1 = CoinStockStub::create(10,CoinStub::create(1.0));
        $coinStocks2 = CoinStockStub::create(10,CoinStub::create(0.25));
        $coinStocks3 = CoinStockStub::create(10,CoinStub::create(0.10));
        $coinStocks4 = CoinStockStub::create(10,CoinStub::create(0.05));
        $coinsStocksOrdered = CoinsStocksStub::create($coinStocks1,$coinStocks2,$coinStocks3,$coinStocks4);

        $this->shouldSearchItemByName($itemName, $item);
        $this->shouldCalculateTotalCoins($coins->total());
        $this->shouldSaveItem($itemToSave);
        $this->shouldFindAllCoinStockOrderedByValue($coinsStocksOrdered);

        $itemBuyed = ($this->handler)($command);

        $this->assertEquals($itemBuyed->itemId(), $itemId);
        $this->assertEquals(0.25,$itemBuyed->change()[0]);
        $this->assertEquals(0.25,$itemBuyed->change()[1]);

    }

    /** @test */
    public function should_buy_item_with_005cents_if_enough_money_and_enough_stock_returning_change()
    {
        $command = BuyItemCommandStub::random();
        $itemId = ItemIdStub::random();
        $itemName = ItemNameStub::create($command->itemName());
        $item = ItemStub::create($itemId, $itemName, 0.10, 10);
        $itemToSave = ItemStub::create($itemId,$itemName, 0.10, 9);
        $coins = CoinsStub::fromValues([0.05,0.05,0.05]);

        $coinStocks1 = CoinStockStub::create(10,CoinStub::create(1.0));
        $coinStocks2 = CoinStockStub::create(10,CoinStub::create(0.25));
        $coinStocks3 = CoinStockStub::create(10,CoinStub::create(0.10));
        $coinStocks4 = CoinStockStub::create(10,CoinStub::create(0.05));
        $coinsStocksOrdered = CoinsStocksStub::create($coinStocks1,$coinStocks2,$coinStocks3,$coinStocks4);

        $this->shouldSearchItemByName($itemName, $item);
        $this->shouldCalculateTotalCoins($coins->total());
        $this->shouldSaveItem($itemToSave);
        $this->shouldFindAllCoinStockOrderedByValue($coinsStocksOrdered);

        $itemBuyed = ($this->handler)($command);

        $this->assertEquals($itemBuyed->itemId(), $itemId);
        $this->assertEquals($itemBuyed->change()[0], 0.05);
    }

    /** @test */
    public function should_buy_item_with_different_coins_if_enough_money_and_enough_stock_returning_change()
    {
        $command = BuyItemCommandStub::random();
        $itemId = ItemIdStub::random();
        $itemName = ItemNameStub::create($command->itemName());
        $item = ItemStub::create($itemId, $itemName, 1.0, 10);
        $itemToSave = ItemStub::create($itemId, $itemName,1.0, 9);
        $coins = CoinsStub::fromValues([0.05,0.05,1.0]);

        $coinStocks1 = CoinStockStub::create(10,CoinStub::create(1.0));
        $coinStocks2 = CoinStockStub::create(10,CoinStub::create(0.25));
        $coinStocks3 = CoinStockStub::create(10,CoinStub::create(0.10));
        $coinStocks4 = CoinStockStub::create(10,CoinStub::create(0.05));
        $coinsStocksOrdered = CoinsStocksStub::create($coinStocks1,$coinStocks2,$coinStocks3,$coinStocks4);

        $this->shouldSearchItemByName($itemName, $item);
        $this->shouldCalculateTotalCoins($coins->total());
        $this->shouldSaveItem($itemToSave);
        $this->shouldFindAllCoinStockOrderedByValue($coinsStocksOrdered);

        $itemBuyed = ($this->handler)($command);
        $this->assertEquals($itemBuyed->itemId(), $itemId);
        $this->assertEquals($itemBuyed->change()[0], 0.1);
    }
}