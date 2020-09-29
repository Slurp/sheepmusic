<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class BlackSheepMusicLibraryExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $this->loadParameters($container, $config);
        $this->loadServices($container);
        $this->loadAnnotations();
    }

    /**
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    protected function loadServices(ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.yml');
        $loader->load('services_repositories.yml');
        $loader->load('services_lastfm.yml');
        $loader->load('services_artwork.yml');
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    protected function loadParameters(ContainerBuilder $container, array &$config)
    {
        $parameters = [
            'ffprobe_path',
            'ffmpeg_path',
            'bitrate',
            'binary_timeout',
            'threads_count',
            'last_fm_api_key',
            'last_fm_api_secret',
        ];
        foreach ($parameters as $attribute) {
            $container->setParameter('black_sheep_music_library.' . $attribute, $config[$attribute]);
        }
    }

    protected function loadAnnotations()
    {
        $this->addAnnotatedClassesToCompile(
            [
                'MusicLibrary\\Controller\\',
            ]
        );
    }
}
