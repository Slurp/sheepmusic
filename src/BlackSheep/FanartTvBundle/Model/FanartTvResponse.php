<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\FanartTvBundle\Model;

use BlackSheep\MusicLibraryBundle\Model\AlbumArtworkSetInterface;
use BlackSheep\MusicLibraryBundle\Model\ArtistArtworkSetInterface;

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
        if (isset($json->hdmusiclogo) && is_array($json->hdmusiclogo)) {
            $this->logos = $json->hdmusiclogo;
        }
        if (isset($json->musiclogo) && is_array($json->musiclogo) && $this->logos !== null) {
            $this->logos = $json->musiclogo;
        }
        if (isset($json->musicbanner) && is_array($json->musicbanner)) {
            $this->banners = $json->musicbanner;
        }
        if (isset($json->artistbackground) && is_array($json->artistbackground)) {
            $this->backgrounds = $json->artistbackground;
        }
        if (isset($json->artistthumb) && is_array($json->artistthumb)) {
            $this->thumbs = $json->artistthumb;
        }
        if (isset($json->artistthumb) && is_array($json->artistthumb)) {
            $this->thumbs = $json->artistthumb;
        }
        if (isset($json->cdart) && is_array($json->cdart)) {
            $this->cdart = $json->cdart;
        }
        if (isset($json->albumcover) && is_array($json->albumcover)) {
            $this->albumcover = $json->albumcover;
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
