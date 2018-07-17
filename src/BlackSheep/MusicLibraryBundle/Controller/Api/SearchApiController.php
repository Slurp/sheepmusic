<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Controller\Api;

use BlackSheep\MusicLibraryBundle\Entity\AlbumEntity;
use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Entity\SongEntity;
use Elastica\Query;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Search Api.
 */
class SearchApiController extends Controller
{
    /**
     * @Route("/search/{query}", name="search")
     *
     * @param $query
     *
     * @return Response
     */
    public function searchAction($query)
    {
        $results = [];
        $results['albums'] = array_map(
            function (AlbumEntity $album) {
                return $album->getApiData();
            },
            $this->container->get('fos_elastica.finder.app.album')->find(
                $this->buildNameQuery($query)
            )
        );

        $results['artists'] = array_map(
            function (ArtistsEntity $artist) {
                return $artist->getApiData();
            },
            $this->container->get('fos_elastica.finder.app.artist')->find(
                $this->buildNameQuery($query)
            )
        );

        $results['songs'] = array_map(
            function (SongEntity $song) {
                return $song->getApiData();
            },
            $this->container->get('fos_elastica.finder.app.song')->find(
                $this->buildTitleQuery($query),
                1000
            )
        );

        return $this->json(
            $results
        );
    }

    /**
     * @param $searchTerm
     *
     * @return Query\Match
     */
    protected function buildNameQuery($searchTerm)
    {
        $nameQuery = new Query\Match();

        $nameQuery->setFieldQuery('name', $searchTerm);
        $nameQuery->setFieldFuzziness('name', 'AUTO');
        $nameQuery->setFieldMinimumShouldMatch('name', '80%');

        return $nameQuery;
    }

    /**
     * @param $searchTerm
     *
     * @return Query\Match
     */
    protected function buildTitleQuery($searchTerm)
    {
        $titleQuery = new Query\Match();

        $titleQuery->setFieldQuery('title', $searchTerm);
        $titleQuery->setFieldFuzziness('title', 'AUTO');
        $titleQuery->setFieldMinimumShouldMatch('title', '80%');

        return $titleQuery;
    }
}
