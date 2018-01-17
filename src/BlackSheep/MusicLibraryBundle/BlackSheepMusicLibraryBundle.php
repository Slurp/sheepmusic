<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
