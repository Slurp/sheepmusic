<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFm\Updater;

use BlackSheep\LastFm\Info\LastFmArtistInfo;
use BlackSheep\MusicLibrary\Entity\SimilarArtist\SimilarArtistEntity;
use BlackSheep\MusicLibrary\Model\ArtistInterface;
use BlackSheep\MusicLibrary\Repository\ArtistRepository;
use LastFmApi\Exception\ApiFailedException;
use LastFmApi\Exception\ConnectionException;

/**
 * Class ArtistUpdater.
 */
class ArtistUpdater
{
    /**
     * @var ArtistRepository
     */
    protected $artistsRepository;

    /**
     * @var LastFmArtistInfo
     */
    protected $client;

    /**
     * @param ArtistRepository $artistsRepository
     * @param LastFmArtistInfo $client
     */
    public function __construct(
        ArtistRepository $artistsRepository,
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
        if (empty($artist->getMusicBrainzId()) === false && \count($artist->getSimilarArtists()) === 0) {
            try {
                $similarArtists = $this->client->getSimilarByMusicBrainzId($artist->getMusicBrainzId());
                if ($similarArtists) {
                    $artist->setSimilarArtists(
                        array_map(
                            function ($similarArtist) use ($artist) {
                                $similar = $this->artistsRepository->getArtistByMusicBrainzId(
                                    $similarArtist['mbid']
                                );
                                if ($similar) {
                                    return SimilarArtistEntity::createNew(
                                        $artist,
                                        $similar,
                                        $similarArtist['match']
                                    );
                                }

                                return null;
                            },
                            $similarArtists
                        )
                    );
                    $this->artistsRepository->save($artist);
                }
            } catch (ConnectionException $connectionException) {
                error_log(__METHOD__.$connectionException->getMessage());
            } catch (ApiFailedException $apiFailedException) {
                error_log(__METHOD__.$apiFailedException->getMessage());
            }
        }
    }
}
