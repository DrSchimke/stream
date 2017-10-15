# Stream

[![Build Status](https://travis-ci.org/DrSchimke/stream.svg)](https://travis-ci.org/DrSchimke/stream)

Chainable stream wrapper for arrays and and other traversables.

Here I use the term _stream_ **not** in the sense of PHP streamWrappers, but more like in _Pipes and Filters Architecture_ – a streaming collection of _things_; actually an _infinite list of things_. (See [also](http://ocw.mit.edu/courses/electrical-engineering-and-computer-science/6-001-structure-and-interpretation-of-computer-programs-spring-2005/video-lectures/6a-streams-part-1/).)

## 1. Installation

Using [composer](https://getcomposer.org/download/):

```bash
composer require sci/stream dev-master
```

## 2. Usage

### 2.1 Creating the stream

```php
use Sci\Stream\ArrayStream;
use Sci\Stream\IteratorStream;

// stream from array
$stream = new ArrayStream([3, 1, 4, 1, 5, 9, 2, 6, 5]);

// stream from ArrayIterator
$stream = new IteratorStream(new \ArrayIterator([2, 7, 1, 8, 2, 8]));

// stream from Generator
function generate()
{
    for ($i = 0; $i < 10; ++$i) {
        yield $i;
    }
}
$stream = new IteratorStream(generate());
```

### 2.2 Map

```php
$incrementedValues = $stream->map(function ($value) {
    return $value + 1;
});
```

### 2.3 Filter

```php
$smallerValues = $stream->filter(function ($value) {
    return $value < 5;
});
```

### 2.4 Reduce

```php
$sum = $stream->reduce(function ($sum, $value) {
    return $sum + $value;
});
```

### 2.5 Chaining

Stream operations can be chained easily:

```php
$stream
    ->filter(function ($value) {
        return $value < 5;
    })
    ->map(function ($value) {
        return 2 * $value;
    })
    ->reduce(function ($sum, $value) {
        return $sum + $value;
    });
```

### 2.6 Getting the Result

To get a stream's content, use iteration with foreach or the ```Stream::toArray()``` method:

```php
foreach ($stream as $value) {
    // $value ...
}

$array = $stream->toArray();
```

## 3. Extending

The library is easily extensible by subclassing. For example, we could add conveniently a CSV parser as stream
source or some wrapper methods around ```Stream::map()``` and ```Stream::filter()```, to achieve a SQL-like
_domain specific language_. (Find the complete example in [StreamExtendingTest](tests/StreamExtendingTest.php).)

```php
class CsvStream extends IteratorStream {
    public static function from($filename) {
        return new parent(self::readCsv($filename));
    }

    public function where(array $condition) {
        return $this->filter(function (array $row) use ($condition) {
            return ...;
        });
    }

    public function select(array $columns) {
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

    public function limit($offset, $limit) {
        // ...
    }

    private static function readCsv($filename) {
        $fd = fopen($filename, 'r');
        $header = fgetcsv($fd);
        while ($row = fgetcsv($fd)) {
            yield array_combine($header, $row);
        }
        fclose($fd);
    }
}

$csvStream = CsvStream::from('example.csv')
    ->where(['first_name' => 'Peter'])
    ->select(['first_name', 'last_name', 'street', 'zip_code', 'city'])
    ->limit(0, 10);
```

## 4. License

All contents of this package are licensed under the [MIT license](LICENSE).
