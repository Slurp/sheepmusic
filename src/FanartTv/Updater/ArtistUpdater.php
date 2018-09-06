<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\FanartTv\Updater;

use BlackSheep\FanartTv\Client\MusicClient;
use BlackSheep\FanartTv\Model\FanartTvResponse;
use BlackSheep\MusicLibrary\Factory\ArtworkFactory;
use BlackSheep\MusicLibrary\Model\ArtistInterface;
use BlackSheep\MusicLibrary\Repository\ArtistRepository;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

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
     * @var MusicClient
     */
    protected $client;

    /**
     * @var ArtworkFactory
     */
    private $artworkFactory;

    /**
     * @param ArtistRepository $artistsRepository
     * @param MusicClient               $client
     * @param ArtworkFactory            $artworkFactory
     */
    public function __construct(
        ArtistRepository $artistsRepository,
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
                $fanArt = new FanartTvResponse(
                    json_decode(
                        $this->client->loadArtist($artist->getMusicBrainzId())->getBody()
                    )
                );
                $this->artworkFactory->addArtworkToArtist($artist, $fanArt);
                $this->artistsRepository->update($artist);
                unset($fanArt);
            } catch (ClientException $e) {
                error_log($e->getMessage());
            } catch (ConnectException $e) {
                error_log($e->getMessage());
            }
        }
    }
}
