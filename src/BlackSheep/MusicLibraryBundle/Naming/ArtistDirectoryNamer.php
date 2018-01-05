<?php

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
