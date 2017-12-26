<?php

namespace BlackSheep\FanartTvBundle\EventListener;

use BlackSheep\FanartTvBundle\Client\MusicClient;
use BlackSheep\FanartTvBundle\Model\FanartTvResponse;
use BlackSheep\MusicLibraryBundle\EventListener\ArtistEventListener;
use BlackSheep\MusicLibraryBundle\Events\ArtistEventInterface;
use BlackSheep\MusicLibraryBundle\Factory\LogoFactory;
use BlackSheep\MusicLibraryBundle\Repository\ArtistRepositoryInterface;

/**
 * ArtistEventSubscriber
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
     * @var LogoFactory
     */
    private $logoFactory;

    /**
     * @param ArtistRepositoryInterface $artistsRepository
     * @param MusicClient $client
     * @param LogoFactory $logoFactory
     */
    public function __construct(
        ArtistRepositoryInterface $artistsRepository,
        MusicClient $client,
        LogoFactory $logoFactory
    ) {
        $this->artistsRepository = $artistsRepository;
        $this->client = $client;
        $this->logoFactory = $logoFactory;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            ArtistEventInterface::ARTIST_EVENT_FETCHED => "fetchedArtist",
            ArtistEventInterface::ARTIST_EVENT_CREATED => "createdArtist",
            ArtistEventInterface::ARTIST_EVENT_UPDATED => "updatedArtist"
        ];
    }

    /**
     * @inheritDoc
     */
    public function fetchedArtist(ArtistEventInterface $event)
    {
        $this->updateArtWork($event);
    }

    /**
     * @inheritDoc
     */
    public function updatedArtist(ArtistEventInterface $event)
    {
        $this->updateArtWork($event);
    }

    /**
     * @inheritDoc
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
        if ($artist->getMusicBrainzId() !== null && count($artist->getLogos()) === 0) {
            $fanart = new FanartTvResponse(
                json_decode(
                    $this->client->loadArtist($artist->getMusicBrainzId())->getBody()
                )
            );
            if ($fanart->getLogos() !== null) {
                $this->logoFactory->addLogosToArtist($artist, $fanart->getLogos());
                $this->artistsRepository->save($artist);
            }
        }
    }
}
