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

use BlackSheep\MusicLibrary\Entity\ArtistsEntity;
use BlackSheep\MusicLibrary\Events\AlbumEvent;
use BlackSheep\MusicLibrary\Events\ArtistEvent;
use BlackSheep\MusicLibrary\Events\ArtistEventInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Artist Api controller.
 */
class ArtistApiController extends BaseApiController
{
    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('black_sheep_music_library.repository.artists_repository');
    }

    /**
     * {@inheritdoc}
     */
    protected function getApiDataModel()
    {
        return $this->get('black_sheep.music_library.api_model.api_artist_data');
    }

    /**
     * @Route("/artist_list", name="get_artist_list")
     *
     * @return Response
     */
    public function getAlbumListAction()
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
    public function getArtistCollectionAction(Request $request)
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
    public function getArtistAction(ArtistsEntity $artist)
    {
        return $this->getDetail($artist);
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
            $this->get('event_dispatcher')->dispatch(
                AlbumEvent::ALBUM_EVENT_UPDATED,
                new AlbumEvent($album)
            );
            $this->get('event_dispatcher')->dispatch(
                AlbumEvent::ALBUM_EVENT_VALIDATE_SONGS,
                new AlbumEvent($album)
            );
        }
        $this->get('event_dispatcher')->dispatch(
            ArtistEventInterface::ARTIST_EVENT_UPDATED,
            new ArtistEvent($artist)
        );

        return $this->getDetail($artist);
    }
}
