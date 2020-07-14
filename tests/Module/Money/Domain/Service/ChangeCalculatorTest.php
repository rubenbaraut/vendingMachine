<?php

namespace App\Tests;

use App\Tests\Stub\CoinsStocksStub;
use App\Tests\Stub\CoinStockStub;
use App\Tests\Stub\CoinStub;
use App\Tests\TestCase\VendingMachineTestCase;
use App\VendingMachine\Module\Money\Domain\Exception\NoCoinStockException;
use App\VendingMachine\Module\Money\Domain\Service\ChangeCalculator;

class ChangeCalculatorTest extends VendingMachineTestCase
{
    private $handler;

    public function setUp()
    {
        $this->handler = new ChangeCalculator($this->coinStockRepository());
    }

    /** @test */
    public function should_throw_exception_if_no_coins_in_stock()
    {
        $this->shouldFindAllCoinStockOrderedByValue();
        $this->expectException(NoCoinStockException::class);
        ($this->handler)(20.0);
    }

    /** @test */
    public function should_return_correct_change()
    {
        $coinStock1 = CoinStockStub::create(10, CoinStub::create(1.0));
        $coinStock2 = CoinStockStub::create(10, CoinStub::create(0.25));
        $coinStock3 = CoinStockStub::create(10, CoinStub::create(0.10));
        $coinStock4 = CoinStockStub::create(10, CoinStub::create(0.05));

        $coinsStocks = CoinsStocksStub::create($coinStock1, $coinStock2, $coinStock3, $coinStock4);
        $this->shouldFindAllCoinStockOrderedByValue($coinsStocks);

        $change = ($this->handler)(10.40);
        $this->assertEquals($change->total(),10.40);
    }

    /** @test */
    public function should_not_return_change_with_indivisible_number()
    {
        $coinStock1 = CoinStockStub::create(10, CoinStub::create(1.0));
        $coinStock2 = CoinStockStub::create(10, CoinStub::create(0.25));
        $coinStock3 = CoinStockStub::create(10, CoinStub::create(0.10));
        $coinStock4 = CoinStockStub::create(10, CoinStub::create(0.05));

        $coinsStocks = CoinsStocksStub::create($coinStock1, $coinStock2, $coinStock3, $coinStock4);
        $this->shouldFindAllCoinStockOrderedByValue($coinsStocks);

        $this->expectException(NoCoinStockException::class);
        ($this->handler)(0.89);
    }

    /** @test */
    public function should_not_return_change_without_enough_quantity_of_coins()
    {
        $coinStock1 = CoinStockStub::create(1, CoinStub::create(1.0));
        $coinStock2 = CoinStockStub::create(1, CoinStub::create(0.25));
        $coinStock3 = CoinStockStub::create(1, CoinStub::create(0.10));
        $coinStock4 = CoinStockStub::create(1, CoinStub::create(0.05));

        $coinsStocks = CoinsStocksStub::create($coinStock1, $coinStock2, $coinStock3, $coinStock4);
        $this->shouldFindAllCoinStockOrderedByValue($coinsStocks);

        $this->expectException(NoCoinStockException::class);
        ($this->handler)(10.25);
    }

}