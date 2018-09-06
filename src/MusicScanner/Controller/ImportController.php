<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicScanner\Controller;

use BlackSheep\MusicScanner\Output\StreamedResponseOutput;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImportController extends Controller
{
    /**
     * @Route("/import", name="import")
     *
     * @return StreamedResponse
     */
    public function importMediaAction()
    {
        $streamedOutput = new StreamedResponseOutput();
        $buffer = 65536 / 8;
        $streamedOutput->setBufferSize($buffer);

        return new StreamedResponse(
            function() use ($streamedOutput) {
                $importer = $this->get('black_sheep_music_scanner.services.media_importer');
                $importer->setOutputInterface($streamedOutput, false);
                $importer->import('/Volumes/Data/Stack/Music');
            }
        );
    }
}
