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
 * If a model has a API ?
 */
interface ApiInterface
{
    /**
     * @return array
     */
    public function getApiData(): array;
}
