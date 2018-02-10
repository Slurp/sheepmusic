<?php

namespace BlackSheep\LastFmBundle\Updater;

use BlackSheep\LastFmBundle\Info\LastFmArtistInfo;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Repository\ArtistRepositoryInterface;
use LastFmApi\Exception\ApiFailedException;
use LastFmApi\Exception\ConnectionException;

/**
 * Class ArtistUpdater
 *
 * @package BlackSheep\LastFmBundle\Updater
 */
class ArtistUpdater
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
     * @param LastFmArtistInfo $client
     */
    public function __construct(
        ArtistRepositoryInterface $artistsRepository,
        LastFmArtistInfo $client
    ) {
        $this->artistsRepository = $artistsRepository;
        $this->client = $client;
    }

    /**
     * @param ArtistInterface $artist
     */
    public function addSimilar(ArtistInterface $artist)
    {
        if (empty($artist->getMusicBrainzId()) === false && count($artist->getSimilarArtists()) === 0) {
            try {
                $similarArtists = $this->client->getSimilarByMusicBrainzId($artist->getMusicBrainzId());
                if ($similarArtists) {
                    $artist->setSimilarArtists(
                        array_map(
                            function ($similarArtist) use ($artist) {
                                return SimilarArtistEntity::createNew(
                                    $artist,
                                    $this->artistsRepository->getArtistByMusicBrainzId(
                                        $similarArtist['mbid']
                                    ),
                                    $similarArtist['match']
                                );
                            },
                            $similarArtists
                        )
                    );
                }
            } catch (ConnectionException $connectionException) {
            } catch (ApiFailedException $apiFailedException) {
            }
        }
    }
}
