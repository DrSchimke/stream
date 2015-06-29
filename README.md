# Stream

[![Build Status](https://travis-ci.org/DrSchimke/stream.svg)](https://travis-ci.org/DrSchimke/stream)

Chainable stream wrapper for arrays and and other traversables.

## Usage

### Creating the stream

```php
use Sci\Stream\ArrayStream;
use Sci\Stream\IteratorStream;

// stream from array
$stream = ArrayStream::create([3, 1, 4, 1, 5, 9, 2, 6, 5]);

// stream from ArrayIterator
$stream = IteratorStream::create(new \ArrayIterator([2, 7, 1, 8, 2, 8]));

// stream from Generator
function generate()
{
    for ($i = 0; $i < 10; ++$i) {
        yield $i;
    }
}
$stream = IteratorStream::create(generate());
```

### Map

```php
$incrementedValues = $stream->map(function ($value) {
    return $value + 1;
});
```

### Filter

```php
$smallerValues = $stream->filter(function ($value) {
    return $value < 5;
});
```

### Reduce

```php
$sum = $stream->reduce(function ($sum, $value) {
    return $sum + $value;
});
```

### Chaining

Stream operations can be chained easily:

```php
$stream
    ->filter(function ($value) {
        return $value < 5;
    })
    ->reduce(function ($sum, $value) {
        return $sum + $value;
    })
    ->reduce(function ($sum, $value) {
        return $sum + $value;
    });
```

### Getting the Result

To get a stream's content, use iteration with foreach or the Stream::toArray() method:

```php
foreach ($stream as $value) {
    // $value ...
}

$array = $stream->toArray();
```
