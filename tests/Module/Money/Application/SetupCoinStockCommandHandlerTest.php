<?php

namespace App\Tests;

use App\Tests\Stub\CoinStockStub;
use App\Tests\Stub\CoinStub;
use App\Tests\Stub\SetupCoinsCommandStub;
use App\Tests\TestCase\VendingMachineTestCase;
use App\VendingMachine\Module\Money\Application\CoinStockAdder;
use App\VendingMachine\Module\Money\Application\SetupCoinStockCommandHandler;


class SetupCoinStockCommandHandlerTest extends VendingMachineTestCase
{
    private $handler;

    public function setUp()
    {
        $adder = new CoinStockAdder($this->coinStockRepository());
        $this->handler = new SetupCoinStockCommandHandler($adder);
    }

    /** @test */
    public function should_create_coin_stock_if_coins_does_not_exist()
    {
        $coin1 = CoinStub::create(0.05);
        $coin2 = CoinStub::create(0.10);
        $coin3 = CoinStub::create(0.25);
        $coin4 = CoinStub::create(1.0);
        $coinStock1 = CoinStockStub::create(1, $coin1);
        $coinStock2 = CoinStockStub::create(1, $coin2);
        $coinStock3 = CoinStockStub::create(1, $coin3);
        $coinStock4 = CoinStockStub::create(1, $coin4);
        $coins = [$coin1->value(), $coin2->value(), $coin3->value(), $coin4->value()];
        $command = SetupCoinsCommandStub::create($coins);
        $this->shouldSearchCoinStockWithValue($coin1->value());
        $this->shouldSearchCoinStockWithValue($coin2->value());
        $this->shouldSearchCoinStockWithValue($coin3->value());
        $this->shouldSearchCoinStockWithValue($coin4->value());
        $this->shouldSaveCoinStock($coinStock1);
        $this->shouldSaveCoinStock($coinStock2);
        $this->shouldSaveCoinStock($coinStock3);
        $this->shouldSaveCoinStock($coinStock4);

        ($this->handler)($command);
    }

    /** @test */
    public function should_update_coin_stock_if_coins_does_not_exist()
    {
        $coin1 = CoinStub::create(0.05);
        $coin2 = CoinStub::create(0.10);
        $coin3 = CoinStub::create(0.25);
        $coin4 = CoinStub::create(1.0);
        $coinStock1 = CoinStockStub::create(10, $coin1);
        $coinStock2 = CoinStockStub::create(5, $coin2);
        $coinStock3 = CoinStockStub::create(3, $coin3);
        $coinStock4 = CoinStockStub::create(20, $coin4);
        $coins = [$coin1->value(), $coin2->value(), $coin3->value(), $coin4->value()];
        $command = SetupCoinsCommandStub::create($coins);
        $this->shouldSearchCoinStockWithValue($coin1->value(), $coinStock1);
        $this->shouldSearchCoinStockWithValue($coin2->value(), $coinStock2);
        $this->shouldSearchCoinStockWithValue($coin3->value(), $coinStock3);
        $this->shouldSearchCoinStockWithValue($coin4->value(), $coinStock4);

        $finalCoinStock1 = CoinStockStub::create(11, $coin1);
        $finalCoinStock2 = CoinStockStub::create(6, $coin2);
        $finalCoinStock3 = CoinStockStub::create(4, $coin3);
        $finalCoinStock4 = CoinStockStub::create(21, $coin4);
        $this->shouldSaveCoinStock($finalCoinStock1);
        $this->shouldSaveCoinStock($finalCoinStock2);
        $this->shouldSaveCoinStock($finalCoinStock3);
        $this->shouldSaveCoinStock($finalCoinStock4);

        ($this->handler)($command);
    }

    /** @test */
    public function should_update_coin_with_repeated_coins_values()
    {
        $coin1 = CoinStub::create(0.05);
        $coin2 = CoinStub::create(0.05);
        $coin3 = CoinStub::create(0.05);
        $coin4 = CoinStub::create(0.05);
        $coinStock1 = CoinStockStub::create(10, $coin1);
        $finalCoinStock1 = CoinStockStub::create(11, $coin1);
        $finalCoinStock2 = CoinStockStub::create(12, $coin1);
        $finalCoinStock3 = CoinStockStub::create(13, $coin1);
        $finalCoinStock4 = CoinStockStub::create(14, $coin1);
        $coins = [$coin1->value(), $coin2->value(), $coin3->value(), $coin4->value()];
        $command = SetupCoinsCommandStub::create($coins);
        $this->shouldSearchCoinStockWithValue($coin1->value(), $coinStock1);
        $this->shouldSearchCoinStockWithValue($coin1->value(), $coinStock1);
        $this->shouldSearchCoinStockWithValue($coin1->value(), $coinStock1);
        $this->shouldSearchCoinStockWithValue($coin1->value(), $coinStock1);
        $this->shouldSaveCoinStock($finalCoinStock1);
        $this->shouldSaveCoinStock($finalCoinStock2);
        $this->shouldSaveCoinStock($finalCoinStock3);
        $this->shouldSaveCoinStock($finalCoinStock4);

        ($this->handler)($command);
    }
}