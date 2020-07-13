<?php

namespace App\Tests;

use App\Tests\Stub\InsertCoinsCommandStub;
use App\Tests\TestCase\VendingMachineTestCase;
use App\VendingMachine\Module\Money\Application\CoinsAdder;
use App\VendingMachine\Module\Money\Application\InsertCoinsCommandHandler;
use App\VendingMachine\Module\Money\Domain\Coin;


class InsertCoinsCommandHandlerTest extends VendingMachineTestCase
{
    private $handler;

    public function setUp()
    {
        $adder = new CoinsAdder($this->coinRepository());
        $this->handler = new InsertCoinsCommandHandler($adder);
    }

    /** @test */
    public function should_add_the_same_number_of_coins_added()
    {
        $command = InsertCoinsCommandStub::random();

        foreach ($command->coins() as $coin) {
            $this->shouldSaveCoins(new Coin($coin));
        }

        ($this->handler)($command);
    }
}