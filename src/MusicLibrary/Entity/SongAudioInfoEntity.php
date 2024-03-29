<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Entity;

use BlackSheep\MusicLibrary\Model\SongAudioInfo;
use Doctrine\ORM\Mapping as ORM;

/**
 * SongAudioInfoEntity.
 *
 * @ORM\Embeddable
 */
class SongAudioInfoEntity extends SongAudioInfo
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $dataformat;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $channels;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $sample_rate;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $bitrate;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $channelmode;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $bitrate_mode;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $lossless;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $encoder_options;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    protected $compression_ratio;
}
