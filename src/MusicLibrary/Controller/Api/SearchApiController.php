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

use BlackSheep\MusicLibrary\Entity\AlbumEntity;
use BlackSheep\MusicLibrary\Entity\ArtistsEntity;
use BlackSheep\MusicLibrary\Entity\SongEntity;
use Elastica\Query;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Search Api.
 */
class SearchApiController extends AbstractController
{
    /**
     * @Route("/search/{query}", name="search")
     *
     * @param string $query
     *
     * @return Response
     */
    public function search($query)
    {
        $results = [];
        $results['artists'] = array_map(
            function (ArtistsEntity $artist) {
                return $artist->getApiData();
            },
            $this->container->get('fos_elastica.finder.sheepmusic_artists.artist')->find(
                $this->buildNameQuery($query),
                100
            )
        );
        $results['albums'] = array_map(
            function (AlbumEntity $album) {
                return $album->getApiData();
            },
            $this->container->get('fos_elastica.finder.sheepmusic_albums.album')->find(
                $this->buildNameQuery($query),
                100
            )
        );
        $results['songs'] = array_map(
            function (SongEntity $song) {
                return $song->getApiData();
            },
            $this->container->get('fos_elastica.finder.sheepmusic_songs.song')->find(
                $this->buildTitleQuery($query),
                100
            )
        );

        return $this->json(
            $results
        );
    }

    /**
     * @param string $searchTerm
     *
     * @return Query\BoolQuery
     */
    protected function buildNameQuery($searchTerm)
    {
        $boolQuery = new Query\BoolQuery();
        $boolQuery->addShould($this->getQueryStringQuery($searchTerm));
        $boolQuery->addShould($this->getMatchQuery('name', $searchTerm));

        return $boolQuery;
    }

    /**
     * @param string $searchTerm
     *
     * @return Query\BoolQuery
     */
    protected function buildTitleQuery($searchTerm)
    {
        $boolQuery = new Query\BoolQuery();
        $boolQuery->addMust($this->getQueryStringQuery($searchTerm));
        $boolQuery->addShould($this->getMatchQuery('title', $searchTerm));

        return $boolQuery;
    }

    /**
     * @param $searchTerm
     *
     * @return Query\QueryString
     */
    protected function getQueryStringQuery($searchTerm)
    {
        $matchQuery = new Query\QueryString($searchTerm);
        $matchQuery->setBoost(2.0);

        return $matchQuery;
    }

    /**
     * @param $field
     * @param $searchTerm
     *
     * @return Query\Match
     */
    protected function getMatchQuery($field, $searchTerm)
    {
        $matchQuery = new Query\Match();
        $matchQuery->setFieldQuery($field, $searchTerm);
        $matchQuery->setFieldFuzziness($field, 'AUTO');
        $matchQuery->setFieldMinimumShouldMatch($field, '95%');
        $matchQuery->setFieldBoost($field, 1.0);

        return $matchQuery;
    }
}
