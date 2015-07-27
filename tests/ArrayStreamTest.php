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
