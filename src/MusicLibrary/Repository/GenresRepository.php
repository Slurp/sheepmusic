<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Repository;

use BlackSheep\MusicLibrary\Entity\GenreEntity;
use BlackSheep\MusicLibrary\Model\GenreInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;

/**
 * SongsRepository.
 */
class GenresRepository extends AbstractRepository implements GenresRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected static function getEntityClass(): string
    {
        return GenreEntity::class;
    }

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
     * @param string $genreName
     *
     * @return GenreInterface
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
     * @param string $genreName
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
     * @return Query
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
