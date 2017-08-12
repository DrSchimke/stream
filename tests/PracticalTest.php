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

use Sci\Stream\ArrayStream;
use Sci\Stream\IteratorStream;
use Sci\Stream\Stream;

class PracticalTest extends \PHPUnit_Framework_TestCase
{
    public function streamProvider()
    {
        return [
            [new ArrayStream([0, 1, 2, 3, 4, 5, 6, 7, 8, 9])],
            [new IteratorStream(new \ArrayIterator([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]))],
            [new IteratorStream($this->generate())],
        ];
    }

    /**
     * @dataProvider streamProvider
     *
     * @test
     */
    public function it_should_create_stream(Stream $stream)
    {
        $this->assertInstanceOf(Stream::class, $stream);
        $this->assertEquals([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], $stream->toArray());
    }

    /**
     * @dataProvider streamProvider
     *
     * @test
     */
    public function it_should_map(Stream $stream)
    {
        $incrementedValues = $stream->map(function ($value) {
            return $value + 1;
        });

        $this->assertInstanceOf(Stream::class, $incrementedValues);
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7, 8, 9, 10], $incrementedValues->toArray());
    }

    /**
     * @dataProvider streamProvider
     *
     * @test
     */
    public function it_should_filter(Stream $stream)
    {
        $smallerValues = $stream->filter(function ($value) {
            return $value < 5;
        });

        $this->assertInstanceOf(Stream::class, $smallerValues);
        $this->assertEquals([0, 1, 2, 3, 4], $smallerValues->toArray());
    }

    /**
     * @dataProvider streamProvider
     *
     * @test
     */
    public function it_should_reduce(Stream $stream)
    {
        $sum = $stream->reduce(function ($sum, $value) {
            return $sum + $value;
        });

        $this->assertEquals(45, $sum);
    }

    /**
     * @dataProvider streamProvider
     *
     * @test
     */
    public function it_should_chain(Stream $stream)
    {
        $sum = $stream
            ->filter(function ($value) {
                return $value < 5;
            })
            ->map(function ($value) {
                return 2 * $value;
            })
            ->reduce(function ($sum, $value) {
                return $sum + $value;
            });

        $this->assertEquals(20, $sum);
    }

    private function generate()
    {
        for ($i = 0; $i < 10; ++$i) {
            yield $i;
        }
    }
}
