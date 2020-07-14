<?php

namespace App\VendingMachine\Module\Item\Domain\Exception;

use DomainException;

class ItemNotFoundException extends DomainException
{
    private $itemId;

    public function __construct($itemId)
    {
        $this->itemId = $itemId;
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'item_not_found';
    }

    public function errorMessage(): string
    {
        return sprintf('Item with id %s not found', $this->itemId);
    }
}