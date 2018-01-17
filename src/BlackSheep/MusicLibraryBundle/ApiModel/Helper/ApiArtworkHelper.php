<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\ApiModel\Helper;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use BlackSheep\MusicLibraryBundle\Model\Media\ArtworkInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * Class ApiArtworkHelper.
 */
class ApiArtworkHelper
{
    /**
     * @param ArtistInterface $artworkSet
     * @param $uploadHelper
     * @param string $baseUrl
     *
     * @return array
     */
    public static function prefixArtworkSetWithUrl(ArtistInterface $artworkSet, UploaderHelper $uploadHelper, $baseUrl)
    {
        $artworks[ArtworkInterface::TYPE_THUMBS] = [];
        $artworks[ArtworkInterface::TYPE_BANNER] = [];
        $artworks[ArtworkInterface::TYPE_BACKGROUND] = [];
        $artworks[ArtworkInterface::TYPE_LOGO] = [];
        foreach ($artworkSet->getArtworks() as $artwork) {
            $artworks[$artwork->getType()][] = $baseUrl .
                $uploadHelper->asset(
                    $artwork,
                    'imageFile'
                );
        }

        return $artworks;
    }
}
