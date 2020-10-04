<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\FanartTv\Model;

use BlackSheep\MusicLibrary\Model\AlbumArtworkSetInterface;
use BlackSheep\MusicLibrary\Model\ArtistArtworkSetInterface;

/**
 * Class FanartTvResponse.
 */
class FanartTvResponse implements ArtistArtworkSetInterface, AlbumArtworkSetInterface
{
    /**
     * @var array
     */
    protected $logos;

    /**
     * @var array
     */
    protected $banners;

    /**
     * @var array
     */
    protected $backgrounds;

    /**
     * @var array
     */
    protected $thumbs;

    /**
     * @var array
     */
    protected $cdart;

    /**
     * @var array
     */
    protected $albumcover;

    /**
     * FanartTvResponse constructor.
     *
     * @param $json
     */
    public function __construct($json)
    {
        //logo's
        $this->getMostLiked($json, 'musiclogo', 'logos');
        $this->getMostLiked($json, 'musicbanner', 'banners');
        $this->getMostLiked($json, 'artistbackground', 'backgrounds');
        $this->getMostLiked($json, 'artistthumb', 'thumbs');
        $this->getMostLiked($json, 'cdart', 'cdart');
        $this->getMostLiked($json, 'albumcover', 'albumcover');

        if (isset($json->albums)) {
            foreach ($json->albums as $mbid => $album) {
                if (isset($album->cdart)) {
                    $this->cdart[$mbid] = $this->getMostLiked($album, 'cdart');
                }
                if (isset($album->albumcover)) {
                    $this->albumcover[$mbid] = $this->getMostLiked($album, 'albumcover');
                }
            }
        }
    }

    /**
     * @param $json
     * @param $key
     * @param null $classProp
     *
     * @return mixed
     */
    protected function getMostLiked($json, string $key, string $classProp = null)
    {
        if (isset($json->{$key}) && \is_array($json->{$key})) {
            usort($json->{$key}, function ($first, $second) { return $first->likes <= $second->likes; });
            if($classProp !== null) {
                return  $this->{$classProp} = $json->{$key}[0];
            }
            return $json->{$key}[0];
        }
    }

    /**
     * @return array
     */
    public function getLogos()
    {
        return $this->logos;
    }

    /**
     * @return array
     */
    public function getBanners()
    {
        return $this->banners;
    }

    /**
     * @return array
     */
    public function getBackgrounds()
    {
        return $this->backgrounds;
    }

    /**
     * @return array
     */
    public function getThumbs()
    {
        return $this->thumbs;
    }

    /**
     * @return array
     */
    public function getCdart()
    {
        return $this->cdart;
    }

    /**
     * @return array
     */
    public function getArtworkCover()
    {
        return $this->albumcover;
    }
}
