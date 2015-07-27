<?php
/*
 * This file is part of the sci/stream package.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sci\Stream;

class ArrayStream extends Stream implements \IteratorAggregate
{
    /** @var array */
    private $array;

    /**
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * @param array $array
     *
     * @return static
     */
    public static function create(array $array)
    {
        return new static($array);
    }

    /**
     * @param callable $mapCallback
     *
     * @return static
     */
    public function map(callable $mapCallback)
    {
        return new static(array_map($mapCallback, $this->array));
    }

    /**
     * @param callable $filterCallback
     *
     * @return static
     */
    public function filter(callable $filterCallback)
    {
        return new static(array_values(array_filter($this->array, $filterCallback)));
    }

    /**
     * @param callable $reduceCallback
     * @param null     $initial
     *
     * @return mixed
     */
    public function reduce(callable $reduceCallback, $initial = null)
    {
        return array_reduce($this->array, $reduceCallback, $initial);
    }

    /**
     * @return \Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->array);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->array;
    }
}
