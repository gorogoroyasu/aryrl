# Aryrl
PHP Array Regularizer  
[![CircleCI](https://circleci.com/gh/gorogoroyasu/aryrl.svg?style=svg)](https://circleci.com/gh/gorogoroyasu/aryrl)
# Usage

```php

use Aryrl/Store;

$array = [
        [1, 2],
        [4, 5, 6],
        [7, 8, 9]
];
$options = [
    'row' => 'max',  # or int >= 1
    'col' => 'max',  # or int >= 1
    'colmns' => ['a'],
    'others' => ['d'],
];

$s = Store($array, $options);
$s->getPruned();
// => [
//  [1, 2, null],
//  [4, 5, 6],
//  [7, 8, 9],
// ]
$s->getNamed();
//  ['a' => 1, 'b' => [2, null]],
//  ['a' => 4, 'b' => [5, 6]],
//  ['a' => 7, 'b' => [8, 9],
// ]
```

