<?php

namespace App\VendingMachine\Module\Item\Application;

use App\VendingMachine\Module\Item\Domain\Exception\ItemNotFoundException;
use App\VendingMachine\Module\Item\Domain\Item;
use App\VendingMachine\Module\Item\Domain\ItemRepository;
use App\VendingMachine\Module\Money\Domain\CoinRepository;
use App\VendingMachine\Module\Money\Domain\CoinStockRepository;
use App\VendingMachine\Module\Money\Domain\Exception\NotEnoughMoneyException;
use App\VendingMachine\Module\Money\Domain\Service\ChangeCalculator;
use App\VendingMachine\Shared\Item\ItemId;

class BuyerService
{
    private $searcher;
    private $coinRepository;
    private $coinStockRepository;
    private $itemRepository;
    private $changeCalculator;

    public function __construct(
        ItemSearcher $searcher,
        CoinRepository $coinRepository,
        CoinStockRepository $coinStockRepository,
        ItemRepository $itemRepository,
        ChangeCalculator $changeCalculator
    ) {
        $this->searcher = $searcher;
        $this->coinRepository = $coinRepository;
        $this->coinStockRepository = $coinStockRepository;
        $this->itemRepository = $itemRepository;
        $this->changeCalculator = $changeCalculator;
    }

    public function __invoke(ItemId $itemId): BuyItemResponse
    {
        $item = ($this->searcher)($itemId);
        $amountAvailable = $this->coinRepository->total();

        $this->guarditem($item, $itemId);
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

    private function guardItem(?Item $item, $itemId): void
    {
        if (null === $item || 0 === $item->stock()) {
            throw new ItemNotFoundException($itemId);
        }
    }

    private function guardMoney(?Item $item, float $amountAvailable): void
    {
        if (!$this->haveEnoughMoneyToBuyItem($item, $amountAvailable)) {
            throw new NotEnoughMoneyException();
        }
    }
}