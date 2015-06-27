<?php

namespace Sci\Tests\Stream;

use Sci\Stream\IteratorStream;
use Sci\Stream\Stream;

class IteratorStreamTest extends AbstractStreamTest
{
    /**
     * returns the system under test
     *
     * @return Stream
     */
    protected function getSut()
    {
        $array = range(0, 99);
        $iterator = new \ArrayIterator($array);

        return IteratorStream::create($iterator);
    }
}
