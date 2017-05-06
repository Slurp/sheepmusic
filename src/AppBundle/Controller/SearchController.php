<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Elastica\Query;

/**
 *
 */
class SearchController extends Controller
{
    /**
     * @Route("/search", name="search")
     * @return Response
     */
    public function searchAction(Request $request)
    {
        $query =  $request->get('query');

        $albums = $this->container->get('fos_elastica.finder.app.album');
        $artists = $this->container->get('fos_elastica.finder.app.artist');
        $songs = $this->container->get('fos_elastica.finder.app.song');
        return $this->render(
            'AppBundle:Search:overview.html.twig',
            [
                'query' => $query,
                'albums' => $albums->find($this->buildNameQuery($query)),
                'artists' => $artists->find($this->buildNameQuery($query)),
                'songs' => $songs->find($this->buildTitleQuery($query),1000),
            ]
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

        $nameQuery->setFieldQuery("name", $searchTerm);
        $nameQuery->setFieldFuzziness("name", 0.7);
        $nameQuery->setFieldMinimumShouldMatch("name", "80%");
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

        $titleQuery->setFieldQuery("title", $searchTerm);
        $titleQuery->setFieldFuzziness("title", 0.7);
        $titleQuery->setFieldMinimumShouldMatch("title", "80%");
        return $titleQuery;
    }
}
