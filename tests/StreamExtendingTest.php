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
use Sci\Stream\Stream;

class StreamExtendingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_create_csv_stream()
    {
        $csvStream = CsvStream::from(__DIR__.'/example.csv')
            ->where(['first_name' => 'Peter'])
            ->select(['id', 'first_name', 'last_name', 'city'])
            ->limit(3, 5);

        $this->assertInstanceOf(Stream::class, $csvStream);

        $cnt = 0;
        foreach ($csvStream as $row) {
            $this->assertArrayHasKey('id', $row);
            $this->assertArrayHasKey('first_name', $row);
            $this->assertArrayHasKey('last_name', $row);
            $this->assertArrayHasKey('city', $row);

            $this->assertEquals('Peter', $row['first_name']);

            ++$cnt;
        }

        $this->assertEquals(5, $cnt);
    }
}

class CsvStream extends IteratorStream
{
    /**
     * @param string $filename
     *
     * @return static
     */
    public static function from($filename)
    {
        return static::create(self::readCsv($filename));
    }

    /**
     * @param array $conditions
     *
     * @return static
     */
    public function where(array $conditions)
    {
        return $this->filter(function (array $row) use ($conditions) {
            foreach ($conditions as $column => $value) {
                if (!array_key_exists($column, $row) || $row[$column] !== $value) {
                    return false;
                }
            }

            return true;
        });
    }

    /**
     * @param array|string[] $columns
     *
     * @return static
     */
    public function select(array $columns)
    {
        return $this->map(function (array $row) use ($columns) {
            $result = [];
            foreach ($columns as $column) {
                if (array_key_exists($column, $row)) {
                    $result[$column] = $row[$column];
                }
            }

            return $result;
        });
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return static
     */
    public function limit($offset, $limit)
    {
        return $this->filter(function (array $row) use ($offset, $limit) {
            static $counter = 0;
            ++$counter;

            return $offset < $counter && $counter <= $offset + $limit;
        });
    }

    /**
     * @param string $filename
     *
     * @return \Generator
     */
    private static function readCsv($filename)
    {
        $fd = fopen($filename, 'r');
        $header = fgetcsv($fd);
        while ($row = fgetcsv($fd)) {
            yield array_combine($header, $row);
        }
        fclose($fd);
    }
}
