<?php

namespace App\Tests;

use App\Tests\Stub\CoinsStub;
use App\Tests\Stub\ReturnCoinsCommandStub;
use App\Tests\TestCase\VendingMachineTestCase;
use App\VendingMachine\Module\Money\Application\CoinsRemover;
use App\VendingMachine\Module\Money\Application\ReturnCoinsCommandHandler;
use App\VendingMachine\Module\Money\Domain\Exception\NoCoinException;


class ReturnCoinsCommandHandlerTest extends VendingMachineTestCase
{
    private $handler;

    public function setUp()
    {
        $remover = new CoinsRemover($this->coinRepository());
        $this->handler = new ReturnCoinsCommandHandler($remover);
    }

    /** @test */
    public function should_remove_all_coins()
    {
        $coinsAdded = CoinsStub::random();
        $command = ReturnCoinsCommandStub::create();
        $this->shouldRemoveCoins($coinsAdded);
        $coinsReturned = ($this->handler)($command);
        $this->assertEquals($coinsReturned->count(), $coinsAdded->count());
    }

    /** @test */
    public function should_throw_exception_if_no_coins()
    {
        $command = ReturnCoinsCommandStub::create();
        $this->expectException(NoCoinException::class);
        $this->shouldRemoveCoins();
        ($this->handler)($command);
    }
}