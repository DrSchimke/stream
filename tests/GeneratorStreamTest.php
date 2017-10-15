<?php

/**
 * This file is part of the sci/stream package.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sci\Stream\Tests;

use Sci\Stream\IteratorStream;

class GeneratorStreamTest extends AbstractStreamTest
{
    public function testFibonacci()
    {
        $stream = new IteratorStream($this->fibonacci(1000));

        $this->assertEquals([1, 1, 2, 3, 5, 8, 13, 21, 34, 55, 89, 144, 233, 377, 610, 987], $stream->toArray());
    }

    /**
     * Returns the system under test
     *
     * Here, the stream of integers 0..99 is realized as an IteratorStream, using a generator.
     *
     * @return IteratorStream
     */
    protected function getSut()
    {
        return new IteratorStream($this->generator());
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

    /**
     * @return \Generator
     */
    private function generator()
    {
        for ($i = 0; $i < 100; ++$i) {
            yield $i;
        }
    }
}
