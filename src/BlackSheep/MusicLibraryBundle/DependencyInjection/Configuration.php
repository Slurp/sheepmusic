<?php

namespace BlackSheep\MusicLibraryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('black_sheep_music_library');

        $rootNode
            ->children()
                ->scalarNode('last_fm_api_key')->defaultValue('')->end()
                ->scalarNode('ffmpeg_path')->defaultValue('/usr/local/bin/ffmpeg')->end()
                ->scalarNode('bitrate')->defaultValue(320)->end()
                ->scalarNode('binary_timeout')->defaultValue(60)->end()
                ->scalarNode('threads_count')->defaultValue(4)->end()
            ->end()
        ->end();
        $treeBuilder->buildTree();
        return $treeBuilder;
    }
}
