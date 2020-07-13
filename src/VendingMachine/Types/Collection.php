<?php
namespace App\VendingMachine\Types;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use function Lambdish\Phunctional\each;

abstract class Collection implements Countable, IteratorAggregate
{
    /** @var array */
    protected $items = [];

    public function __construct(array $items)
    {
        Assert::arrayOf($this->type(), $items);

        $this->items = $items;
    }

    abstract protected function type(): string;

    public function getIterator()
    {
        return new ArrayIterator($this->items());
    }

    public function count()
    {
        return count($this->items());
    }

    protected function each(callable $fn)
    {
        each($fn, $this->items());
    }

    public function items()
    {
        return $this->items;
    }
}
