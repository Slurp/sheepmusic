<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicScanner\Command;

use BlackSheep\MusicScanner\Services\MediaImporter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Commando: music import.
 */
class ImportMusicCommand extends Command
{
    /**
     * @var MediaImporter
     */
    protected $mediaImporter;

    /**
     * @var ParameterBagInterface
     */
    protected $param;

    public function __construct(ParameterBagInterface $param, MediaImporter $mediaImporter)
    {
        parent::__construct();
        $this->mediaImporter = $mediaImporter;
        $this->param = $param;
    }
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('music_scanner:import_music_command')
            ->setDescription('import music')
            ->addOption(
                'full',
                null,
                InputOption::VALUE_REQUIRED,
                'do a full import',
                false
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->mediaImporter->setOutputInterface($output, false);
        //$this->mediaImporter->import('/Volumes/Data/Stack/Music');
        $this->mediaImporter->import(
            $this->param->get('black_sheep_music_library.import_path'),
            $input->getOption('full')
        );
        return self::SUCCESS;
    }
}
