<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Class SongAudioInfo
 *
 * @package BlackSheep\MusicLibraryBundle\Model
 */
class SongAudioInfo implements SongAudioInfoInterface
{
    /**
     * @var string
     */
    protected $dataformat;

    /**
     * @var int
     */
    protected $channels;

    /**
     * @var int
     */
    protected $sample_rate;

    /**
     * @var float
     */
    protected $bitrate;

    /**
     * @var string
     */
    protected $channelmode;

    /**
     * @var string
     */
    protected $bitrate_mode;

    /**
     * @var bool
     */
    protected $lossless;

    /**
     * @var string
     */
    protected $encoder_options;

    /**
     * @var float
     */
    protected $compression_ratio;

    /**
     * @return array
     */
    public static function getAllowedKeys()
    {
        return [
            'dataformat',
            'channels',
            'sample_rate',
            'bitrate',
            'channelmode',
            'bitrate_mode',
            'lossless',
            'encoder_options',
            'compression_ratio'
        ];
    }

    /**
     * @param array $info
     */
    public function __construct($info)
    {
        if (is_array($info)) {
            foreach ($info as $key => $value) {
                if (in_array($key, static::getAllowedKeys())) {
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDataformat()
    {
        return $this->dataformat;
    }

    /**
     * {@inheritdoc}
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * {@inheritdoc}
     */
    public function getSampleRate()
    {
        return $this->sample_rate;
    }

    /**
     * {@inheritdoc}
     */
    public function getBitrate()
    {
        return $this->bitrate;
    }

    /**
     * {@inheritdoc}
     */
    public function getChannelmode()
    {
        return $this->channelmode;
    }

    /**
     * {@inheritdoc}
     */
    public function getBitrateMode()
    {
        return $this->bitrate_mode;
    }

    /**
     * {@inheritdoc}
     */
    public function getLossless()
    {
        return $this->lossless;
    }

    /**
     * {@inheritdoc}
     */
    public function getEncoderOptions()
    {
        return $this->encoder_options;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompressionRatio()
    {
        return $this->compression_ratio;
    }
}
