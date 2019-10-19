<?php

namespace Arylr\Test;

use Arylr\Store;
use PHPUnit\Framework\TestCase;

class StoreTest extends TestCase
{

    /**
     * @param array $expected
     * @param array $ary
     * @param array $option
     * @dataProvider providePrune
     */
    public function testPrune($expected, $ary, $option)
    {
        $s = new Store($ary, $option);
        $this->assertEquals($s->getPruned(), $expected);
    }

    # PROVIDERS
    #
    #
    #
    private static $BASIC_ARY = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9]
    ];

    private static $BASIC_ARY_WITH_BLANK = [
        [1],
        [4, 5, 6],
        [7, 8, 9]
    ];
    public function providePrune()
    {
        return [
          [
              // convert nothing
              self::$BASIC_ARY,
              self::$BASIC_ARY,
              []
          ],
          [
              // fill blank with null
              [
                  [1, null, null],
                  [4, 5, 6],
                  [7, 8, 9]
              ],
              self::$BASIC_ARY_WITH_BLANK,
              []
          ],
          [
              // fill blank with string empty
              [
                  [1, 'empty', 'empty'],
                  [4, 5, 6],
                  [7, 8, 9]
              ],
              self::$BASIC_ARY_WITH_BLANK,
              ['fill' => 'empty']
          ],
          [
              // reduce row numbers
              [
                  [1, 2, 3],
                  [4, 5, 6]
              ],
              self::$BASIC_ARY,
              ['row' => 2, 'col' => 3]
          ],
          [
              // reduce row numbers
              [
                  [1, 2, 3],
                  [4, 5, 6]
              ],
              self::$BASIC_ARY,
              ['row' => 2]
          ],
          [
              [
                  [1, 2],
                  [4, 5],
                  [7, 8],
              ],
              self::$BASIC_ARY,
              ['row' => 3, 'col' => 2]
          ],
          [
              [
                  [1, 2],
                  [4, 5],
                  [7, 8],
              ],
              self::$BASIC_ARY,
              ['col' => 2]
          ],
        ];
    }

    /**
     * @param array $expected
     * @param array $ary
     * @param array $option
     * @dataProvider provideNamed
     */
    public function testNamed($expected, $ary, $option)
    {
        $s = new Store($ary, $option);
        $this->assertEquals($s->getNamed(), $expected);
    }

    public function provideNamed()
    {
        return [
            [
                // only one column is named.
                [
                    ['a' => 1, 'default' => [2, 3]],
                    ['a' => 4, 'default' => [5, 6]],
                    ['a' => 7, 'default' => [8, 9]]
                ],
                self::$BASIC_ARY,
                [
                    'columns' => ['a'],
                ]
            ],
            [
                // only one column is named.
                // default key name is changed
                [
                    ['a' => 1, 'special' => [2, 3]],
                    ['a' => 4, 'special' => [5, 6]],
                    ['a' => 7, 'special' => [8, 9]]
                ],
                self::$BASIC_ARY,
                [
                    'columns' => ['a'],
                    'others' => 'special'
                ]
            ],
            [
                // columns keys is ignored.
                [
                    ['a' => 1, 'special' => [2, 3]],
                    ['a' => 4, 'special' => [5, 6]],
                    ['a' => 7, 'special' => [8, 9]]
                ],
                self::$BASIC_ARY,
                [
                    'columns' => ['x' => 'a'],
                    'others' => 'special'
                ]
            ],
        ];
    }

}