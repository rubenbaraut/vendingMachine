<?php

namespace App\Tests\Stub;

use App\VendingMachine\Module\Money\Application\ReturnCoinsCommand;

final class ReturnCoinsCommandStub
{
    public static function create()
    {
        return new ReturnCoinsCommand();
    }
}
