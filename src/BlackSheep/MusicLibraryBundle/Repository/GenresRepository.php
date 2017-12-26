<?php

namespace BlackSheep\MusicLibraryBundle\Repository;

use BlackSheep\MusicLibraryBundle\Entity\GenreEntity;
use BlackSheep\MusicLibraryBundle\Model\GenreInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;

/**
 * SongsRepository
 */
class GenresRepository extends AbstractRepository implements GenresRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function queryAll()
    {
        return $this->createQueryBuilder('a')->addOrderBy('a.name', 'ASC')->getQuery()->setFetchMode(
            GenreEntity::class,
            'artist',
            ClassMetadata::FETCH_EAGER
        );
    }

    /**
     * @param               $genreName
     *
     * @return GenreInterface|null
     */
    public function addOrUpdateByName($genreName)
    {
        $genre = $this->getByName($genreName);
        if ($genre === null) {
            $genre = GenreEntity::createGenre($genreName);
            $this->save($genre);
        }

        return $genre;
    }

    /**
     * @param $genreName
     *
     * @return null|object
     */
    public function getByName($genreName)
    {
        return $this->findOneBy(
            ['name' => $genreName]
        );
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    public function getRecentGenres()
    {
        return $this->createQueryBuilder('a')
            ->addOrderBy('a.createdAt', 'DESC')
            ->getQuery()->setFetchMode(GenreEntity::class, 'artist', ClassMetadata::FETCH_EAGER);
    }

    /**
     * @return Query
     */
    public function getMostPlayedGenres()
    {
        return $this->createQueryBuilder('a')
            ->where('a.playCount > 0')
            ->andWhere('a.playCount is not NULL')
            ->addOrderBy('a.playCount', 'DESC')
            ->getQuery()->setFetchMode(GenreEntity::class, 'artist', ClassMetadata::FETCH_EAGER);
    }

    /**
     * @return array
     */
    public function getGenresList()
    {
        return $this->createQueryBuilder('a')->select(
            ['a.id', 'a.slug', 'a.name', 'a.createdAt', 'a.updatedAt', 'a.playCount']
        )->getQuery()->execute(
            [],
            Query::HYDRATE_ARRAY
        );
    }

    /**
     * @return array
     */
    public function getRecentGenresList()
    {
        return $this->createQueryBuilder('a')->select(
            ['a.id', 'a.slug', 'a.name', 'a.createdAt', 'a.updatedAt', 'a.playCount']
        )->addOrderBy('a.createdAt', 'DESC')->getQuery()->execute(
            [],
            Query::HYDRATE_ARRAY
        );
    }
}
