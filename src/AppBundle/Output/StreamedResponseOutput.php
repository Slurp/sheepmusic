<?php
/**
 * @author: @{USER} <stephan@bureaublauwgeel.nl>
 * Date: 15/03/17
 * Time: 23:45
 * @copyright 2017 Bureau Blauwgeel
 * @version 1.0
 */
namespace AppBundle\Output;

use Symfony\Component\Console\Output\Output;

/**
 * Write buffers to a streamedResponse
 */
class StreamedResponseOutput extends Output
{
    /**
     * @var int
     */
    static protected $bufferSizeApache = 4096;

    /**
     * @var mixed|null
     */
    protected $bufferSize;

    /**
     * @inheritDoc
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
     * @inheritDoc
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
