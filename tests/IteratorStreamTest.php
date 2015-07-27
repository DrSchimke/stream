<?php

/*
 * This file is part of the sci/stream package.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sci\Tests\Stream;

use Sci\Stream\IteratorStream;
use Sci\Stream\Stream;

class IteratorStreamTest extends AbstractStreamTest
{
    public function testFibonacci()
    {
        $stream = new IteratorStream($this->fibonacci(1000));

        $this->assertEquals([1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377, 610, 987], $stream->toArray());
    }

    /**
     * returns the system under test.
     *
     * @return Stream
     */
    protected function getSut()
    {
        $array = range(0, 99);
        $iterator = new \ArrayIterator($array);

        return IteratorStream::create($iterator);
    }

    /**
     * Generates the fibonacci sequence up to $max.
     *
     * @param int $max
     *
     * @return \Generator
     */
    private function fibonacci($max)
    {
        for ($x = 0, $y = 1; $y <= $max; $z = $x + $y, $x = $y, $y = $z) {
            yield $y;
        }
    }
}
