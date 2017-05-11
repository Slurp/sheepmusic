<?php

namespace AppBundle\Controller;

use AppBundle\Utils\UtilsPagerFanta;
use BlackSheep\MusicLibraryBundle\Entity\AlbumEntity;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class AlbumController extends Controller
{
    /**
     * @Route("/albums/recent/{page}", defaults={"page" = 1}, name="library_recent_albums")
     *
     * @param $page
     *
     * @return Response
     */
    public function recentAlbumsAction($page = 1)
    {
        return $this->renderAlbumsOverview(
            UtilsPagerFanta::getByQuery(
                $this->getDoctrine()->getRepository(AlbumEntity::class)->getRecentAlbums(),
                $page
            ),
            'library_recent_albums'
        );
    }

    /**
     * @Route("/albums/most-played/{page}", defaults={"page" = 1},
     *     name="library_mostplayed_albums")
     *
     * @param $page
     *
     * @return Response
     */
    public function mostPlayedAction($page = 1)
    {
        return $this->renderAlbumsOverview(
            UtilsPagerFanta::getByQuery(
                $this->getDoctrine()->getRepository(AlbumEntity::class)->getMostPlayedAlbums(),
                $page
            ),
            'library_mostplayed_albums'
        );
    }

    /**
     * @Route("/albums/{page}", defaults={"page" = 1}, name="library_albums")
     *
     * @param $page
     *
     * @return Response
     */
    public function albumsAction($page)
    {
        return $this->renderAlbumsOverview(
            UtilsPagerFanta::getAllPaged(
                $this->getDoctrine()->getRepository(AlbumEntity::class),
                $page
            ),
            "library_albums"
        );
    }

    /**
     * @Route("/album/{album}", name="library_album",requirements={"album"=".+"})
     * @ParamConverter(
     *     "album",
     *     class="BlackSheepMusicLibraryBundle:AlbumEntity",
     *     options={"mapping": {"album": "slug"}}
     * )
     *
     * @param AlbumEntity $album
     *
     * @return Response
     */
    public function albumDetailAction(AlbumEntity $album)
    {
        return $this->render(
            'AppBundle:Album:detail.html.twig',
            ['artist' => $album->getArtist(), 'album' => $album]
        );
    }

    /**
     * @param Pagerfanta $pager
     *
     * @param $routeName
     *
     * @return Response
     */
    protected function renderAlbumsOverview(Pagerfanta $pager, $routeName)
    {
        return $this->render(
            'AppBundle:Album:overview.html.twig',
            [
                'pager' => $pager,
                'albums' => $pager->getCurrentPageResults(),
                'routeName' => $routeName
            ]
        );
    }
}
