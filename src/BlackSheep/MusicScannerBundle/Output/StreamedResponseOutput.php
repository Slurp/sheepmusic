<?php

namespace BlackSheep\MusicScannerBundle\Output;

use Symfony\Component\Console\Output\Output;

/**
 * Write buffers to a streamedResponse.
 */
class StreamedResponseOutput extends Output
{
    /**
     * @var int
     */
    protected static $bufferSizeApache = 4096;

    /**
     * @var mixed|null
     */
    protected $bufferSize;

    /**
     * {@inheritdoc}
     */
    public function __construct($verbosity = self::VERBOSITY_NORMAL, $decorated = false, $formatter = null)
    {
        parent::__construct($verbosity, $decorated, $formatter);
        ob_start();
    }

    /**
     * @param int $bufferSize
     */
    public function setBufferSize($bufferSize = 0)
    {
        $this->bufferSize = $bufferSize ? $bufferSize : max(static::$bufferSizeApache, 0);
    }

    /**
     * {@inheritdoc}
     */
    protected function doWrite($message, $newline)
    {
        if (!is_scalar($message)) {
            throw new InvalidArgumentException();
        }

        echo str_pad($message, $this->bufferSize);
        ob_flush();
        flush();
    }

    /**
     * @param $output
     * @param $htmlSelector
     */
    public function outPlaceholder($output, $htmlSelector)
    {
        $out = '<script type="text/javascript">';
        $out .= 'document.getElementById("' .
            $htmlSelector .
            '").innerHTML = "' .
            htmlentities(
                $output,
                ENT_QUOTES,
                'UTF-8'
            ) .
            '" ';
        $out .= '</script>';

        $this->doWrite($out, false);
    }
}
