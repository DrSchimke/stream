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

use Sci\Stream\ArrayStream;
use Sci\Stream\Stream;

class ArrayStreamTest extends AbstractStreamTest
{
    /**
     * @test
     */
    public function it_should_create()
    {
        $stream = ArrayStream::create([]);

        self::assertInstanceOf(Stream::class, $stream);
    }

    /**
     * Returns the system under test
     *
     * Here, the stream of integers 0..99 is realized as an ArrayStream.
     *
     * @return ArrayStream
     */
    protected function getSut()
    {
        $array = range(0, 99);

        return new ArrayStream($array);
    }
}
