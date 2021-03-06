<?php

/**
 * This file is part of the sci/stream package.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sci\Stream;

class IteratorStream extends Stream implements \IteratorAggregate
{
    /** @var \Traversable */
    private $iterator;

    /**
     * @param \Traversable $iterator
     */
    public function __construct(\Traversable $iterator)
    {
        $this->iterator = $iterator;
    }

    /**
     * @param \Traversable $iterator
     *
     * @return static
     */
    public static function create(\Traversable $iterator)
    {
        return new static($iterator);
    }

    /**
     * @param callable $mapCallback
     *
     * @return static
     */
    public function map(callable $mapCallback)
    {
        $generator = $this->doMap($mapCallback);

        return new static($generator);
    }

    /**
     * @param callable $filterCallback
     *
     * @return static
     */
    public function filter(callable $filterCallback)
    {
        $generator = $this->doFilter($filterCallback);

        return new static($generator);
    }

    /**
     * @param callable $reduceCallback
     * @param null     $initial
     *
     * @return mixed
     */
    public function reduce(callable $reduceCallback, $initial = null)
    {
        foreach ($this->iterator as $value) {
            $initial = call_user_func($reduceCallback, $initial, $value);
        }

        return $initial;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];

        foreach ($this->iterator as $value) {
            $result[] = $value;
        }

        return $result;
    }

    /**
     * @see \IteratorAggregate::getIterator()
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        return $this->iterator;
    }

    /**
     * @param callable $mapCallback
     *
     * @return \Generator
     */
    protected function doMap(callable $mapCallback)
    {
        foreach ($this->iterator as $value) {
            yield call_user_func($mapCallback, $value);
        }
    }

    /**
     * @param callable $filterCallback
     *
     * @return \Generator
     */
    protected function doFilter(callable $filterCallback)
    {
        foreach ($this->iterator as $value) {
            if (call_user_func($filterCallback, $value)) {
                yield $value;
            }
        }
    }
}
