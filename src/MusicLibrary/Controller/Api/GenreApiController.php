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

use BlackSheep\MusicLibrary\ApiModel\ApiGenreData;
use BlackSheep\MusicLibrary\Entity\GenreEntity;
use BlackSheep\MusicLibrary\Repository\GenresRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Genre Api controller.
 */
class GenreApiController extends BaseApiController
{
    public function __construct(
        GenresRepository $repository,
        ApiGenreData $apiData
    ) {
        $this->repository = $repository;
        $this->apiData = $apiData;
    }

    /**
     * @Route("/genre_list", name="get_genre_list")
     *
     * @return Response
     */
    public function getGenreList()
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
    public function getGenre(GenreEntity $genre)
    {
        return $this->getDetail($genre);
    }
}
