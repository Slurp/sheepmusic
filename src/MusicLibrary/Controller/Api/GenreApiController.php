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

use BlackSheep\MusicLibrary\Entity\GenreEntity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Genre Api controller.
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
     * {@inheritdoc}
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
    public function getGenreListAction()
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
