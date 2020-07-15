<?php

namespace App\VendingMachine\Module\Item\Application;

use App\VendingMachine\Module\Item\Domain\Item;
use App\VendingMachine\Module\Item\Domain\ItemRepository;
use App\VendingMachine\Module\Money\Domain\CoinRepository;
use App\VendingMachine\Module\Money\Domain\Exception\NotEnoughMoneyException;
use App\VendingMachine\Module\Money\Domain\Service\ChangeCalculator;

class BuyerService
{
    private $coinRepository;
    private $itemRepository;
    private $changeCalculator;

    public function __construct(
        CoinRepository $coinRepository,
        ItemRepository $itemRepository,
        ChangeCalculator $changeCalculator
    ) {
        $this->coinRepository = $coinRepository;
        $this->itemRepository = $itemRepository;
        $this->changeCalculator = $changeCalculator;
    }

    public function __invoke(Item $item): BuyItemResponse
    {
        $amountAvailable = $this->coinRepository->total();
        $this->guardMoney($item, $amountAvailable);

        $item->buy();
        $this->itemRepository->save($item);
        $importToReturn = $amountAvailable - $item->price();

        $change = ($this->changeCalculator)($importToReturn);

        return new BuyItemResponse($item->itemId()->value(), $change->toArray());
    }

    private function haveEnoughMoneyToBuyItem(Item $item, float $amountAvailable): bool
    {
        if ($item->price() > $amountAvailable) {
            return false;
        }

        return true;
    }

    private function guardMoney(?Item $item, float $amountAvailable): void
    {
        if (!$this->haveEnoughMoneyToBuyItem($item, $amountAvailable)) {
            throw new NotEnoughMoneyException();
        }
    }
}