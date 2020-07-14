<?php

namespace App\VendingMachine\Module\Item\Application;

use App\VendingMachine\Shared\Item\ItemId;

class BuyItemCommandHandler
{
    private $buyer;
    private $itemSearcher;

    public function __construct(BuyerService $buyer, ItemSearcher $itemSearcher)
    {
        $this->buyer = $buyer;
        $this->itemSearcher = $itemSearcher;
    }

    public function __invoke(BuyItemCommand $command): BuyItemResponse
    {
        $itemId = new ItemId($command->itemId());
        return ($this->buyer)($itemId);
    }


}