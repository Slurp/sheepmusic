<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Events;

use BlackSheep\MusicLibrary\Model\ArtistInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class ArtistEvent.
 */
class ArtistEvent extends Event implements ArtistEventInterface
{
    /**
     * @var ArtistInterface
     */
    protected $artist;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param ArtistInterface $artist
     * @param null            $value
     */
    public function __construct(ArtistInterface $artist, $value = null)
    {
        $this->artist = $artist;
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getArtist(): ArtistInterface
    {
        return $this->artist;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->artist;
    }
}
