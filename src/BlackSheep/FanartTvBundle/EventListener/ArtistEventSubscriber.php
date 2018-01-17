<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\FanartTvBundle\EventListener;

use BlackSheep\FanartTvBundle\Client\MusicClient;
use BlackSheep\FanartTvBundle\Model\FanartTvResponse;
use BlackSheep\MusicLibraryBundle\EventListener\ArtistEventListener;
use BlackSheep\MusicLibraryBundle\Events\ArtistEventInterface;
use BlackSheep\MusicLibraryBundle\Factory\ArtworkFactory;
use BlackSheep\MusicLibraryBundle\Repository\ArtistRepositoryInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

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
     * @var MusicClient
     */
    protected $client;

    /**
     * @var ArtworkFactory
     */
    private $artworkFactory;

    /**
     * @param ArtistRepositoryInterface $artistsRepository
     * @param MusicClient               $client
     * @param ArtworkFactory            $artworkFactory
     */
    public function __construct(
        ArtistRepositoryInterface $artistsRepository,
        MusicClient $client,
        ArtworkFactory $artworkFactory
    ) {
        $this->artistsRepository = $artistsRepository;
        $this->client = $client;
        $this->artworkFactory = $artworkFactory;
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
        $this->updateArtWork($event);
    }

    /**
     * {@inheritdoc}
     */
    public function updatedArtist(ArtistEventInterface $event)
    {
        $this->updateArtWork($event);
    }

    /**
     * {@inheritdoc}
     */
    public function createdArtist(ArtistEventInterface $event)
    {
        $this->updateArtWork($event);
    }

    /**
     * @param ArtistEventInterface $artistEvent
     */
    protected function updateArtWork(ArtistEventInterface $artistEvent)
    {
        $artist = $artistEvent->getArtist();
        if (empty($artist->getMusicBrainzId()) === false && count($artist->getArtworks()) === 0) {
            try {
                $fanart = new FanartTvResponse(
                    json_decode(
                        $this->client->loadArtist($artist->getMusicBrainzId())->getBody()
                    )
                );
                $this->artworkFactory->addArtworkToArtist($artist, $fanart);
                $this->artistsRepository->save($artist);
            } catch (ClientException $e) {
                error_log($e->getMessage());
            } catch (ConnectException $e) {
                error_log($e->getMessage());
            }
        }
    }
}
