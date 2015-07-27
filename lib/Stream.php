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

abstract class Stream
{
    /**
     * @param callable $mapCallback
     *
     * @return Stream
     */
    abstract public function map(callable $mapCallback);

    /**
     * @param callable $filterCallback
     *
     * @return Stream
     */
    abstract public function filter(callable $filterCallback);

    /**
     * @param callable $reduceCallback
     * @param null     $initial
     *
     * @return mixed
     */
    abstract public function reduce(callable $reduceCallback, $initial = null);

    /**
     * @return array
     */
    abstract public function toArray();
}
