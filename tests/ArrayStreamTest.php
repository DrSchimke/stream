<?php

namespace Sci\Tests\Stream;

use Sci\Stream\ArrayStream;
use Sci\Stream\Stream;

class ArrayStreamTest extends AbstractStreamTest
{
    /**
     * returns the system under test.
     *
     * @return Stream
     */
    protected function getSut()
    {
        $array = range(0, 99);

        return ArrayStream::create($array);
    }
}
