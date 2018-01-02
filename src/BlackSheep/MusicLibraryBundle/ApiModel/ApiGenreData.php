<?php

namespace BlackSheep\MusicLibraryBundle\ApiModel;

use BlackSheep\MusicLibraryBundle\Entity\AlbumEntity;
use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;
use BlackSheep\MusicLibraryBundle\Entity\GenreEntity;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Routing\RouterInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Generates a array for the API.
 */
class ApiGenreData extends AbstractApiData implements ApiDataInterface
{
    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * @inheritDoc
     */
    public function __construct(
        RouterInterface $router,
        UploaderHelper $uploaderHelper,
        ManagerRegistry $managerRegistry = null
    ) {
        parent::__construct($router, $uploaderHelper);
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiData($object)
    {
        if ($object instanceof GenreEntity) {
            $albums = [];
            foreach (
                $this->managerRegistry->getRepository(
                    AlbumEntity::class
                )->findBy(['genre' => $object]) as $entity
            ) {
                $albums[] = $entity->getApiData();
            }
            $artists = [];
            foreach (
                $this->managerRegistry->getRepository(
                    ArtistsEntity::class
                )->getArtistsByGenre($object) as $entity
            ) {
                $artists[] = $entity->getApiData();
            }

            $apiData = $object->getApiData();
            $apiData['albums'] = $albums;
            $apiData['artists'] = $artists;

            return $apiData;
        }

        return null;
    }
}