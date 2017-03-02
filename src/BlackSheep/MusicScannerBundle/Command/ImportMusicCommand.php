<?php

namespace BlackSheep\MusicScannerBundle\Command;

use BlackSheep\MusicScannerBundle\Services\MediaImporter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *
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
        $importer = new MediaImporter('/Users/slangeweg/Music');
        $importer->setOutputInterface($output);
        $importer->setEntityManager($this->getContainer()->get('doctrine.orm.default_entity_manager'));
        $importer->setLastFmObjects(
            $this->getContainer()->get('black_sheep_music_library.last_fm.last_fm_artist'),
            $this->getContainer()->get('black_sheep_music_library.last_fm.last_fm_album')
        );
        $importer->import();
    }
}
