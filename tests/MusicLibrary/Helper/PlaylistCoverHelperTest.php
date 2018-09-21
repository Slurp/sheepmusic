<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\Tests\MusicLibrary\Helper;

use BlackSheep\MusicLibrary\Helper\PlaylistCoverHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class PlaylistCoverHelperTest.
 */
class PlaylistCoverHelperTest extends TestCase
{
    public function testCalculateColumnsAndRows()
    {
        $helper = new PlaylistCoverHelper();
        foreach (range(2, 10) as $number) {
            $grid = $helper->calculateColumnsAndRows(range(1, $number));
            switch ($number) {
                case 10:
                    static::assertSame($grid['columns'], 3);
                    static::assertSame($grid['rows'], 4);

                    break;
                case 9:
                case 8:
                case 7:
                    static::assertSame($grid['columns'], 3);
                    static::assertSame($grid['rows'], 3);
                    break;
                case 6:
                case 5:
                    static::assertSame($grid['columns'], 2);
                    static::assertSame($grid['rows'], 3);
                    break;
                case 4:
                case 3:
                    static::assertSame($grid['columns'], 2);
                    static::assertSame($grid['rows'], 2);
                    break;
                case 2:
                    static::assertSame($grid['columns'], 1);
                    static::assertSame($grid['rows'], 2);
                    break;
            }
        }
    }
}
