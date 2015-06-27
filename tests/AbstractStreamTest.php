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

        $this->assertEquals(4950, $result);
    }

    /**
     * returns the system under test
     *
     * @return Stream
     */
    abstract protected function getSut();
}
