<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Model;

/**
 * Class SongAudioInfo.
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
    public static function getAllowedKeys(): array
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
            'compression_ratio',
        ];
    }

    /**
     * @param array $info
     */
    public function __construct($info)
    {
        if (\is_array($info)) {
            foreach ($info as $key => $value) {
                if (\in_array($key, static::getAllowedKeys(), true)) {
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $info = [];
        foreach (static::getAllowedKeys() as $key) {
            $info[$key] = $this->$key;
        }

        return $info;
    }

    /**
     * @return string
     */
    public function getDataformat(): string
    {
        return $this->dataformat;
    }

    /**
     * @return int
     */
    public function getChannels(): int
    {
        return $this->channels;
    }

    /**
     * @return int
     */
    public function getSampleRate(): int
    {
        return $this->sample_rate;
    }

    /**
     * @return float
     */
    public function getBitrate(): float
    {
        return $this->bitrate;
    }

    /**
     * @return string
     */
    public function getChannelmode(): string
    {
        return $this->channelmode;
    }

    /**
     * @return string
     */
    public function getBitrateMode(): string
    {
        return $this->bitrate_mode;
    }

    /**
     * @return bool
     */
    public function getLossless(): bool
    {
        return $this->lossless;
    }

    /**
     * @return string
     */
    public function getEncoderOptions(): string
    {
        return $this->encoder_options;
    }

    /**
     * @return float
     */
    public function getCompressionRatio(): float
    {
        return $this->compression_ratio;
    }
}
