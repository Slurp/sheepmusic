<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
