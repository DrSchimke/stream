<?php

namespace Sci\Tests\Stream;

use Sci\Stream\Stream;

/**
 * Common test base for all sub-classes of Stream (ArrayStream, IteratorStream)
 */
abstract class AbstractStreamTest extends \PHPUnit_Framework_TestCase
{
    public function testMap()
    {
        $stream = $this->getSut();

        $result = $stream->map(function ($value) {
            return 2 * $value;
        });

        $this->assertInstanceOf(Stream::class, $result);

        foreach ($result as $value) {
            $this->assertTrue(0 === $value % 2);
        }
    }

    public function testFilter()
    {
        $stream = $this->getSut();

        $result = $stream->filter(function ($value) {
            return 1 === $value % 2;
        });

        $this->assertInstanceOf(Stream::class, $result);

        foreach ($result as $value) {
            $this->assertTrue(1 === $value % 2);
        }
    }

    public function testReduce()
    {
        $stream = $this->getSut();

        $result = $stream->reduce(function ($subTotal, $addend) {
            return $subTotal + $addend;
        });

        // result should be the sum of integers 0..99, i.e. 4950
        $this->assertEquals(4950, $result);
    }

    public function testToArray()
    {
        $stream = $this->getSut();

        $result = $stream->toArray();

        $this->assertEquals(range(0, 99), $result);
    }

    public function testChain()
    {
        $stream = $this->getSut();

        $result = $stream
            ->filter(function ($value) {
                return 0 === $value % 3;
            })
            ->map(function ($value) {
                return 2 * $value;
            })
            ->map(function ($value) {
                return 1 + $value;
            })
            ->toArray();

        $this->assertEquals(range(1, 199, 6), $result);
    }

    /**
     * Returns the system under test
     *
     * For these tests, the resulting Stream should provide a sequence of integers between 0 and 99.
     *
     * @return Stream
     */
    abstract protected function getSut();
}
