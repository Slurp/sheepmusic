<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Naming;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class ArtistDirectoryNamer implements DirectoryNamerInterface
{
    /**
     * {@inheritdoc}
     */
    public function directoryName($object, PropertyMapping $mapping)
    {
        if ($object instanceof ArtistInterface) {
            return $object->getSlug();
        }
    }
}
