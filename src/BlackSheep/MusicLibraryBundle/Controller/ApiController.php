<?php

namespace BlackSheep\MusicLibraryBundle\Controller;

use BlackSheep\MusicLibraryBundle\Entity\Albums;
use BlackSheep\MusicLibraryBundle\Entity\Artists;
use BlackSheep\MusicLibraryBundle\Entity\Songs;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class ApiController extends FOSRestController
{
    /**
     * @Route("/user", options={"expose"=true})
     */
    public function getUserAction()
    {
        $data = [
            'currentUser' => $this->getUser(),
        ];
        $view = $this->view($data);

        return $this->handleView($view);
    }

    /**
     * @Route("/artist", options={"expose"=true})
     */
    public function getArtistAction()
    {

        $adapter    = new ArrayAdapter($this->getDoctrine()->getRepository(Artists::class)->findAll());
        $pager = new Pagerfanta($adapter);

        return $this->handleView($this->view(['artists' => $pager->getCurrentPageResults()]));
    }

    /**
     * @Route("/albums", options={"expose"=true})
     * @return Response
     */
    public function albumsAction()
    {
        $data = [
            'albums' => $this->getDoctrine()->getRepository(Albums::class)->findAll(),
        ];
        $view = $this->view($data);

        return $this->handleView($view);
    }

    /**
     * @Route("/song/{song}", options={"expose"=true})
     * @param Songs $song
     * @return Response
     */
    public function getSongInfoAction(Songs $song)
    {
        $view = $this->view($song);

        return $this->handleView($view);
    }
}
