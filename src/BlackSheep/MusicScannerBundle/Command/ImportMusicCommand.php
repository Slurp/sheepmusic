<?php

namespace BlackSheep\MusicScannerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Commando: music import.
 */
class ImportMusicCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('music_scanner:import_music_command')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $importer = $this->getContainer()->get('black_sheep_music_scanner.services.media_importer');
        $importer->setOutputInterface($output, false);
        $importer->import('/Volumes/Data/Stack/Music');
        //$importer->import('/Users/slangeweg/Music/');
    }
}
