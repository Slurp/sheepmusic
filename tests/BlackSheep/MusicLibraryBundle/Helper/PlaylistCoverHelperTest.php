<?php
/**
 * Created by PhpStorm.
 * User: slangeweg
 * Date: 24/06/2018
 * Time: 22:33
 */

namespace Tests\BlackSheep\MusicLibraryBundle\Helper;

use BlackSheep\MusicLibraryBundle\Helper\PlaylistCoverHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class PlaylistCoverHelperTest
 *
 * @package Tests\BlackSheep\MusicLibraryBundle\Helper
 */
class PlaylistCoverHelperTest extends TestCase
{
    /**
     *
     */
    public function testCalculateColumnsAndRows()
    {
        $helper = new PlaylistCoverHelper();
        foreach (range(2, 10) as $number) {
            $grid = $helper->calculateColumnsAndRows(range(1, $number));
            switch ($number) {
                case 10:
                    static::assertEquals($grid['columns'], 3);
                    static::assertEquals($grid['rows'], 4);

                    break;
                case 9:
                case 8:
                case 7:
                    static::assertEquals($grid['columns'], 3);
                    static::assertEquals($grid['rows'], 3);
                    break;
                case 6:
                case 5:
                    static::assertEquals($grid['columns'], 2);
                    static::assertEquals($grid['rows'], 3);
                    break;
                case 4:
                case 3:
                    static::assertEquals($grid['columns'], 2);
                    static::assertEquals($grid['rows'], 2);
                    break;
                case 2:
                    static::assertEquals($grid['columns'], 1);
                    static::assertEquals($grid['rows'], 2);
                    break;
            }
        }
    }
}
