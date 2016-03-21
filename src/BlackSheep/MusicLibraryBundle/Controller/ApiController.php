<?php

namespace BlackSheep\MusicLibraryBundle\Controller;

use BlackSheep\MusicLibraryBundle\Entity\Albums;
use BlackSheep\MusicLibraryBundle\Entity\Artists;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 *
 */
class ApiController extends FOSRestController
{
    /**
     * @Route("/user", name="api_user", options={"expose"=true})
     */
    public function userAction()
    {
        $data = array(
            'currentUser' => $this->getUser()
        );
        $view = $this->view($data);
        return $this->handleView($view);
    }

    /**
     * @Route("/artist", name="api_artist", options={"expose"=true})
     */
    public function artistAction()
    {

        $adapter = new ArrayAdapter($this->getDoctrine()->getRepository(Artists::class)->findAll());
        $pagerFanta = new Pagerfanta($adapter);

        return $this->handleView($this->view(['artists' => $pagerFanta->getCurrentPageResults()]));
    }

    /**
     * @Route("/albums", name="api_albums", options={"expose"=true})
     */
    public function albumsAction()
    {
        $data = array(
            'albums' => $this->getDoctrine()->getRepository(Albums::class)->findAll()
        );
        $view = $this->view($data);
        return $this->handleView($view);
    }
}
