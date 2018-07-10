<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Events;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ArtistEvent
 *
 * @package BlackSheep\MusicLibraryBundle\Events
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
