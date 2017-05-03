<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
                'albums' => $albums->find($query),
                'artists' => $artists->find($query),
                'songs' => $songs->find($query),
            ]
        );
    }
}
