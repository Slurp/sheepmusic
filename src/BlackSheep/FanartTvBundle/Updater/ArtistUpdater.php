<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\FanartTvBundle\Updater;

use BlackSheep\FanartTvBundle\Client\MusicClient;
use BlackSheep\FanartTvBundle\Model\FanartTvResponse;
use BlackSheep\MusicLibraryBundle\Factory\ArtworkFactory;
use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Repository\ArtistRepositoryInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

/**
 * Class ArtistUpdater.
 */
class ArtistUpdater
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
     * @param ArtistInterface $artist
     */
    public function updateArtWork(ArtistInterface $artist)
    {
        if (empty($artist->getMusicBrainzId()) === false) {
            try {
                $fanart = new FanartTvResponse(
                    json_decode(
                        $this->client->loadArtist($artist->getMusicBrainzId())->getBody()
                    )
                );
                $this->artworkFactory->addArtworkToArtist($artist, $fanart);
                $this->artistsRepository->update();
                unset($fanart);
            } catch (ClientException $e) {
                error_log($e->getMessage());
            } catch (ConnectException $e) {
                error_log($e->getMessage());
            }
        }
    }
}
