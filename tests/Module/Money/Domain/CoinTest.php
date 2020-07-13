<?php
namespace App\Tests;

use App\VendingMachine\Module\Money\Domain\Coin;
use App\VendingMachine\Module\Money\Domain\Exception\InvalidCoinException;
use PHPUnit\Framework\TestCase;

class CoinTest extends TestCase
{
    /** @test */
    public function should_create_money_with_value_005()
    {
        $money = new Coin(0.05);
        $this->assertEquals($money->value(), 0.05);
    }

    /** @test */
    public function should_create_money_with_value_010()
    {
        $money = new Coin(0.10);
        $this->assertEquals($money->value(), 0.10);
    }

    /** @test */
    public function should_create_money_with_value_025()
    {
        $money = new Coin(0.25);
        $this->assertEquals($money->value(), 0.25);
    }

    /** @test */
    public function should_create_money_with_with_value_1()
    {
        $money = new Coin(1.0);
        $this->assertEquals($money->value(), 1.0);
    }

    /** @test */
    public function should_throw_exception_when_coin_is_invalid()
    {
        $this->expectException(InvalidCoinException::class);
        $money = new Coin(0.22);
    }
}