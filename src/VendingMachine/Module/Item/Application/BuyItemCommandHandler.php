<?php

namespace App\VendingMachine\Module\Item\Application;

use App\VendingMachine\Shared\Item\ItemId;

class BuyItemCommandHandler
{
    private $buyer;

    public function __construct(BuyerService $buyer)
    {
        $this->buyer = $buyer;
    }

    public function __invoke(BuyItemCommand $command): BuyItemResponse
    {
        $itemId = new ItemId($command->itemId());
        return ($this->buyer)($itemId);
    }


}