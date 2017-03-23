<?php

namespace BlackSheep\MusicLibraryBundle\Controller\Api;

use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Model\Artist;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Artist Api controller
 */
class ArtistApiController extends Controller
{
    /**
     * @Route("/artists", name="get_artists")
     */
    public function getArtistsAction()
    {
        $adapter = new DoctrineORMAdapter(
            $this->getDoctrine()->getRepository(ArtistsEntity::class)->queryAll(),
            false
        );
        $pager = new Pagerfanta($adapter);
        $artists = [];
        $apiData = $this->get('black_sheep.music_library.api_model.api_artist_data');
        /** @var Artist $artist */
        foreach ($pager->getCurrentPageResults() as $artist) {
            $artists[] = $apiData->getApiData($artist);
        }

        return $this->json($artists);
    }

    /**
     * @Route("/artist/{artist}", name="get_artist")
     *
     * @param ArtistsEntity $artist
     *
     * @return Response
     */
    public function getArtistAction(ArtistsEntity $artist)
    {
        return $this->json($this->get('black_sheep.music_library.api_model.api_artist_data')->getApiData($artist));
    }
}
