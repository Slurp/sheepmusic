<?php

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * SongAudioInfo.
 */
interface SongAudioInfoInterface
{
    /**
     * @return array
     */
    public static function getAllowedKeys(): array;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return string
     */
    public function getDataformat(): string;

    /**
     * @return int
     */
    public function getChannels(): int;

    /**
     * @return int
     */
    public function getSampleRate(): int;

    /**
     * @return float
     */
    public function getBitrate(): float;

    /**
     * @return string
     */
    public function getChannelmode(): string;

    /**
     * @return string
     */
    public function getBitrateMode(): string;

    /**
     * @return bool
     */
    public function getLossless(): bool;

    /**
     * @return string
     */
    public function getEncoderOptions(): string;

    /**
     * @return float
     */
    public function getCompressionRatio(): float;
}
