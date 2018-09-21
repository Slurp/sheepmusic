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
        if (isset($json->hdmusiclogo) && \is_array($json->hdmusiclogo)) {
            $this->logos = $json->hdmusiclogo;
        }
        if (isset($json->musiclogo) && \is_array($json->musiclogo) && $this->logos !== null) {
            $this->logos = $json->musiclogo;
        }
        if (isset($json->musicbanner) && \is_array($json->musicbanner)) {
            $this->banners = $json->musicbanner;
        }
        if (isset($json->artistbackground) && \is_array($json->artistbackground)) {
            $this->backgrounds = $json->artistbackground;
        }
        if (isset($json->artistthumb) && \is_array($json->artistthumb)) {
            $this->thumbs = $json->artistthumb;
        }
        if (isset($json->artistthumb) && \is_array($json->artistthumb)) {
            $this->thumbs = $json->artistthumb;
        }

        if (isset($json->albums)) {
            foreach ($json->albums as $mbid => $album) {
                if (isset($album->cdart)) {
                    $this->cdart[$mbid] = $album->cdart;
                }
                if (isset($album->albumcover)) {
                    $this->albumcover[$mbid] = $album->albumcover;
                }
            }
        }
        if (isset($json->cdart)) {
            $this->cdart = $json->cdart;
        }
        if (isset($json->albumcover)) {
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
