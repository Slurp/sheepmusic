<?php
namespace AppBundle\Controller;

use AppBundle\Output\StreamedResponseOutput;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 *
 */
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
            function () use ($streamedOutput) {
                $importer = $this->get('black_sheep_music_scanner.services.media_importer');
                $importer->setOutputInterface($streamedOutput, false);
                $importer->import('/Users/slangeweg/Music');
            }
        );
    }
}
