<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Model;

/**
 * Interface GenreInterface.
 */
interface GenreInterface extends ApiInterface, PlayCountInterface
{
    /**
     * @param $name
     *
     * @return $this
     */
    public static function createGenre($name);

    /**
     * @return mixed
     */
    public function getSlug();

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param mixed $name
     *
     * @return GenreInterface
     */
    public function setName($name);
}
