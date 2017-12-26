<?php

namespace BlackSheep\MusicLibraryBundle\Controller\Api;

use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Artist Api controller
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
     * {@inheritDoc}
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
}
