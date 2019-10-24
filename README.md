# Aryrl
PHP Array Regularizer  
[![CircleCI](https://circleci.com/gh/gorogoroyasu/aryrl.svg?style=svg)](https://circleci.com/gh/gorogoroyasu/aryrl)
# Usage

There are more samples in [tests/StoreTest.php](https://github.com/gorogoroyasu/aryrl/blob/master/tests/StoreTest.php)

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
$s->getPrunedT(); # transpose
// => [
//  [1, 4, 7],
//  [2, 5, 8],
//  [null, 6, 9],
// ]
$s->getNamed();
//  ['a' => 1, 'b' => [2, null]],
//  ['a' => 4, 'b' => [5, 6]],
//  ['a' => 7, 'b' => [8, 9],
// ]
$s->getNamedT(); # transpose
//  [
//      'a' => [1, 4, 7],
//      'default' => [[2, 3], [5, 6], [8, 9]],
//  ],
// ]

/** Checking uniqueness is only implemented for named property */
$array = [
    [1, 2, 3],
    [1, 2, 3],
    [2, 3, 4],
];
$s = Store($array, $options);
$s->namedUniqueness();
//  [
//      'a' => [1 => [0, 1]],
//      'b' => [2 => [0, 1]],
//      'c' => [3 => [0, 1]],
//  ],

$s->namedUniqueness('a');
//  [1 => [0, 1]],


/** Checking uniqueness is only implemented for named property */
$array = [
    [1, 2, null],
    [1, 2, null],
    [null, null, null],
];
$s = Store($array, ['drop' => true]);
$s->getPruned();

// => [
//  [1, 2],
//  [4, 5],
// ]

```


# Caution
This Library only treats 2 dimensional array.
