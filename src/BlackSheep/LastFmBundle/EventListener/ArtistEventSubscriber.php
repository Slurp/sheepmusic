<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFmBundle\EventListener;

use BlackSheep\LastFmBundle\Info\LastFmArtistInfo;
use BlackSheep\MusicLibraryBundle\EventListener\ArtistEventListener;
use BlackSheep\MusicLibraryBundle\Events\ArtistEventInterface;
use BlackSheep\MusicLibraryBundle\Repository\ArtistRepositoryInterface;
use LastFmApi\Exception\ApiFailedException;
use LastFmApi\Exception\ConnectionException;

/**
 * ArtistEventSubscriber.
 */
class ArtistEventSubscriber implements ArtistEventListener
{
    /**
     * @var ArtistRepositoryInterface
     */
    protected $artistsRepository;

    /**
     * @var LastFmArtistInfo
     */
    protected $client;

    /**
     * @param ArtistRepositoryInterface $artistsRepository
     * @param LastFmArtistInfo          $client
     */
    public function __construct(
        ArtistRepositoryInterface $artistsRepository,
        LastFmArtistInfo $client
    ) {
        $this->artistsRepository = $artistsRepository;
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            ArtistEventInterface::ARTIST_EVENT_FETCHED => 'fetchedArtist',
            ArtistEventInterface::ARTIST_EVENT_CREATED => 'createdArtist',
            ArtistEventInterface::ARTIST_EVENT_UPDATED => 'updatedArtist',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fetchedArtist(ArtistEventInterface $event)
    {
        $this->addSimilar($event);
    }

    /**
     * {@inheritdoc}
     */
    public function updatedArtist(ArtistEventInterface $event)
    {
        $this->addSimilar($event);
    }

    /**
     * {@inheritdoc}
     */
    public function createdArtist(ArtistEventInterface $event)
    {
        $this->addSimilar($event);
    }

    /**
     * @param ArtistEventInterface $artistEvent
     */
    protected function addSimilar(ArtistEventInterface $artistEvent)
    {
        $artist = $artistEvent->getArtist();
        if (empty($artist->getMusicBrainzId()) === false && count($artist->getSimilarArtists()) === 0) {
            try {
                $similarArtists = $this->client->getSimilarByMusicBrainzId($artist->getMusicBrainzId());
                if ($similarArtists) {
                    $artist->setSimilarArtists(
                        $this->artistsRepository->findBy(
                            ['musicBrainzId' => array_column($similarArtists, 'mbid')]
                        )
                    );
                }
            } catch (ConnectionException $connectionException) {
            } catch (ApiFailedException $apiFailedException) {
            }
        }
    }
}
