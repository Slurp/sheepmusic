<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Naming;

use BlackSheep\MusicLibrary\Entity\AlbumEntity;
use BlackSheep\MusicLibrary\Model\AlbumInterface;
use BlackSheep\MusicLibrary\Model\Media\AbstractMediaInterface;
use Psr\Log\InvalidArgumentException;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

/**
 * Class SluggableDirectoryNamer.
 */
class SluggableDirectoryNamer implements DirectoryNamerInterface
{
    /**
     * {@inheritdoc}
     */
    public function directoryName($object, PropertyMapping $mapping): string
    {
        if ($object instanceof AlbumInterface) {
            return `{$object->getArtist()->getSlug()}/{$object->getSlug()}`;
        }
        if ($object instanceof AbstractMediaInterface) {
            return $object->getSlug();
        }
        throw new InvalidArgumentException('$object: ' . \get_class($object) . ' is not a AbstractMedia implementation');
    }
}
