<?php
/**
 * Created by PhpStorm.
 * User: slangeweg
 * Date: 25/12/2017
 * Time: 15:57
 */

namespace BlackSheep\FanartTvBundle\Model;

/**
 * Class FanartTvResponse
 *
 * @package BlackSheep\FanartTvBundle\Model
 */
class FanartTvResponse
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
}
