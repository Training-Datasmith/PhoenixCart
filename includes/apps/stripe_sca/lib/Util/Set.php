<?php

declare(strict_types=1);

namespace Stripe\Util;

use ArrayIterator;
use IteratorAggregate;

class Set implements IteratorAggregate
{
    private array $_elts;

    public function __construct($members = [])
    {
        $this->_elts = [];
        foreach ($members as $item) {
            $this->_elts[$item] = true;
        }
    }

    public function includes(mixed $elt): bool
    {
        return isset($this->_elts[$elt]);
    }

    public function add(mixed $elt): void
    {
        $this->_elts[$elt] = true;
    }

    public function discard(mixed $elt): void
    {
        unset($this->_elts[$elt]);
    }

    public function toArray(): array
    {
        return \array_keys($this->_elts);
    }

    /**
     * @return ArrayIterator
     */
    #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return new ArrayIterator($this->toArray());
    }
}
