<?php

namespace BlackSheep\MusicLibraryBundle;

use BlackSheep\MusicLibraryBundle\DependencyInjection\BlackSheepMusicLibraryExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * A Bundle for a Music Library.
 */
class BlackSheepMusicLibraryBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }

    /**
     * @return BlackSheepMusicLibraryExtension
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new BlackSheepMusicLibraryExtension();
        }

        return $this->extension;
    }
}
