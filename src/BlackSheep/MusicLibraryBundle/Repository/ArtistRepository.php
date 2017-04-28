<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Entity\ArtistsEntity;

/**
 * SongsRepository
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArtistRepository extends AbstractRepository implements ArtistRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function queryAll()
    {
        return $this->createQueryBuilder('a')
            ->addOrderBy('a.slug', 'ASC')
            ->getQuery();
    }

    /**
     * {@inheritdoc}
     */
    public function addOrUpdate($artistName, $musicBrainzId = null)
    {
        $artistEntity = $this->getArtistByMusicBrainzId($musicBrainzId);

        if ($artistEntity === null) {
            $artistEntity = $this->getArtistByName($artistName);
        }
        if ($artistEntity === null) {
            $artistEntity = ArtistsEntity::createNew($artistName, $musicBrainzId);
        }

        return $artistEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function getArtistByMusicBrainzId($musicBrainzId = null)
    {
        if ($musicBrainzId !== null && $musicBrainzId !== '') {
            return $this->findOneBy(
                ['musicBrainzId' => $musicBrainzId]
            );
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getArtistByName($artistName)
    {
        return $this->findOneBy(
            ['name' => $artistName]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getArtistAlbumByName($artist, $albumName)
    {
        if ($artist instanceof ArtistsEntity) {
            return $this->findOneBy(
                ['id' => $artist->getId(), 'albums.name' => $albumName]
            );
        }

        return null;
    }
}
