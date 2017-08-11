<?php

/**
 * This file is part of the sci/stream package.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sci\Tests\Stream;

use Sci\Stream\IteratorStream;

class IteratorStreamTest extends AbstractStreamTest
{
    /**
     * Returns the system under test
     *
     * Here, the stream of integers 0..99 is realized as an IteratorStream, using an ArrayIterator.
     *
     * @return IteratorStream
     */
    protected function getSut()
    {
        $array = range(0, 99);
        $iterator = new \ArrayIterator($array);

        return IteratorStream::create($iterator);
    }
}
