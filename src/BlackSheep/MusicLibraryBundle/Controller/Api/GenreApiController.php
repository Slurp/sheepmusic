<?php

namespace BlackSheep\MusicLibraryBundle\Controller\Api;

use BlackSheep\MusicLibraryBundle\Entity\GenreEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Genre Api controller
 */
class GenreApiController extends BaseApiController
{
    /**
     * {@inheritdoc}
     */
    protected function getRepository()
    {
        return $this->get('black_sheep_music_library.repository.genre_repository');
    }

    /**
     * {@inheritDoc}
     */
    protected function getApiDataModel()
    {
        return $this->get('black_sheep.music_library.api_model.api_genre_data');
    }

    /**
     * @Route("/genre_list", name="get_genre_list")
     *
     * @return Response
     */
    public function getAlbumListAction()
    {
        return $this->getList();
    }

    /**
     * @Route("/genre/{genre}", name="get_genre")
     *
     * @param GenreEntity $genre
     *
     * @return Response
     */
    public function getGenreAction(GenreEntity $genre)
    {
        return $this->getDetail($genre);
    }
}
