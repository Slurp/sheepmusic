<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicScanner;

use BlackSheep\MusicScanner\DependencyInjection\BlackSheepMusicScannerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * BlackSheepMusicScanner
 */
class BlackSheepMusicScanner extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }

    /**
     * @return BlackSheepMusicScannerExtension()
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new BlackSheepMusicScannerExtension();
        }

        return $this->extension;
    }
}
