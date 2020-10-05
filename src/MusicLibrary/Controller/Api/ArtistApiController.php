<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Controller\Api;

use BlackSheep\MusicLibrary\ApiModel\ApiArtistData;
use BlackSheep\MusicLibrary\Entity\ArtistsEntity;
use BlackSheep\MusicLibrary\Events\AlbumEvent;
use BlackSheep\MusicLibrary\Events\ArtistEvent;
use BlackSheep\MusicLibrary\Events\ArtistEventInterface;
use BlackSheep\MusicLibrary\Factory\PlaylistFactory;
use BlackSheep\MusicLibrary\Repository\ArtistRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Artist Api controller.
 */
class ArtistApiController extends BaseApiController
{
    /**
     * @var PlaylistFactory
     */
    protected $playlistFactory;

    /**
     * @var EventDispatcherInterface
     */
    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(
        PlaylistFactory $playlistFactory,
        ArtistRepository $repository,
        ApiArtistData $apiData,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->repository = $repository;
        $this->apiData = $apiData;
        $this->playlistFactory = $playlistFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Route("/artist_list", name="get_artist_list")
     *
     * @return Response
     */
    public function getArtistList()
    {
        return $this->getList();
    }

    /**
     * @Route("/artist_collection", name="get_artist_collection")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getArtistCollection(Request $request)
    {
        return $this->getCollection($request->get('objects'));
    }

    /**
     * @Route("/artist/{artist}", name="get_artist")
     *
     * @param ArtistsEntity $artist
     *
     * @return Response
     */
    public function getArtist(ArtistsEntity $artist)
    {
        return $this->getDetail($artist);
    }

    /**
     * @Route("/artist/playlist/{artist}", name="get_artist_playlist")
     *
     * @param ArtistsEntity $artist
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getSmartPlaylistForArtist(ArtistsEntity $artist)
    {
        return $this->json(
            $this->get('black_sheep.music_library.api_model.api_playlist_data')->getApiData(
                $this->playlistFactory->createSmartPlaylistForArtist($artist)
            )
        );
    }

    /**
     * @Route("/artist/update/{artist}", name="update_artist")
     *
     * @param ArtistsEntity $artist
     *
     * @return Response
     */
    public function updateMetaData(ArtistsEntity $artist)
    {
        foreach ($artist->getAlbums() as $album) {
            $this->eventDispatcher->dispatch(
                new AlbumEvent($album),
                AlbumEvent::ALBUM_EVENT_UPDATED,
            );
            $this->eventDispatcher->dispatch(
                new AlbumEvent($album),
                AlbumEvent::ALBUM_EVENT_VALIDATE_SONGS,
            );
        }
        $this->eventDispatcher->dispatch(
            new ArtistEvent($artist),
            ArtistEventInterface::ARTIST_EVENT_UPDATED,
        );

        return $this->getDetail($artist);
    }
}
