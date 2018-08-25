<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\ApiModel;

use BlackSheep\MusicLibrary\Entity\AlbumEntity;
use BlackSheep\MusicLibrary\Entity\ArtistsEntity;
use BlackSheep\MusicLibrary\Entity\GenreEntity;
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
     * {@inheritdoc}
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
