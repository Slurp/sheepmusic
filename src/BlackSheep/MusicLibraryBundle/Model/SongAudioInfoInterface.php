<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * SongAudioInfo.
 */
interface SongAudioInfoInterface
{
    /**
     * @return string
     */
    public function getDataformat();

    /**
     * @return int
     */
    public function getChannels();

    /**
     * @return int
     */
    public function getSampleRate();

    /**
     * @return float
     */
    public function getBitrate();

    /**
     * @return string
     */
    public function getChannelmode();

    /**
     * @return string
     */
    public function getBitrateMode();

    /**
     * @return bool
     */
    public function getLossless();

    /**
     * @return string
     */
    public function getEncoderOptions();

    /**
     * @return float
     */
    public function getCompressionRatio();
}
