<?php

namespace AppBundle\Controller;

use AppBundle\Utils\UtilsPagerFanta;
use BlackSheep\MusicLibraryBundle\Entity\AlbumEntity;
use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * A DefaultController, why change something that works.
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->forward('AppBundle:Default:recentAlbums');
    }

    /**
     * @Route("/artists/{page}", defaults={"page" = 1}, name="library_artists")
     * @param $page
     *
     * @return Response
     */
    public function artistAction($page = 1)
    {
        $pager = UtilsPagerFanta::getAllPaged(
            $this->getDoctrine()->getRepository(ArtistsEntity::class),
            $page
        );

        return $this->render(
            'AppBundle:Artist:overview.html.twig',
            [
                'pager' => $pager,
                'artists' => $pager->getCurrentPageResults()
            ]
        );
    }

    /**
     * @Route("/artist/{artist}", name="library_artist")
     * @ParamConverter(
     *     "artist",
     *     class="BlackSheepMusicLibraryBundle:ArtistsEntity",
     *     options={"mapping": {"artist": "slug"}}
     * )
     *
     * @param ArtistsEntity $artist
     *
     * @return Response
     */
    public function artistDetailAction(ArtistsEntity $artist)
    {
        return $this->render('AppBundle:Artist:detail.html.twig', ['artist' => $artist]);
    }

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
}
