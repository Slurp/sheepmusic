<?php
namespace BlackSheep\MusicLibraryBundle\Controller;

use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Entity\SongEntity;
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
        $view = $this->view([
            'currentUser' => $this->getUser(),
        ]);

        return $this->handleView($view);
    }

    /**
     * @Route("/artist", options={"expose"=true})
     */
    public function getArtistAction()
    {
        $adapter = new ArrayAdapter($this->getDoctrine()->getRepository(ArtistsEntity::class)->findAll());
        $pager = new Pagerfanta($adapter);
        return $this->handleView($this->view(['artists' => $pager->getCurrentPageResults()]));
    }

    /**
     * @Route("/albums", options={"expose"=true})
     * @return Response
     */
    public function albumsAction()
    {
        $view = $this->view([
            'albums' => $this->getDoctrine()->getRepository(ArtistsEntity::class)->findAll(),
        ]);

        return $this->handleView($view);
    }

    /**
     * @Route("/song/{song}", options={"expose"=true})
     * @param SongEntity $song
     *
     * @return Response
     */
    public function getSongInfoAction(SongEntity $song)
    {
        $view = $this->view($song->getApiData());

        return $this->handleView($view);
    }
}
