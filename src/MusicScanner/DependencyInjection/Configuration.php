<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicScanner\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('black_sheep_music_scanner');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
                ->children()
                    ->scalarNode('import_path')->isRequired()->end()
                ->end()
            ->end();
        $treeBuilder->buildTree();

        return $treeBuilder;
    }
}
