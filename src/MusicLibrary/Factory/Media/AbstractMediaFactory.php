<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Factory\Media;

use BlackSheep\MusicLibrary\Entity\Media\AbstractMediaInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Handler\UploadHandler;

/**
 * Class AbstractMediaFactory.
 */
class AbstractMediaFactory
{
    /**
     * @var UploadHandler
     */
    protected $uploadHandler;

    /**
     * @var string
     */
    protected string $kernelRootDir;

    /**
     * @var Filesystem
     */
    protected Filesystem $filesystem;

    /**
     * AbstractMediaFactory constructor.
     *
     * @param UploadHandler $uploadHandler
     * @param $projectDir
     */
    public function __construct(UploadHandler $uploadHandler, $projectDir)
    {
        $this->uploadHandler = $uploadHandler;
        $this->kernelRootDir = $projectDir;
        $this->filesystem = new Filesystem();
    }

    /**
     * @param AbstractMediaInterface $entity
     * @param string                 $url
     * @param string                 $name
     */
    public function copyExternalFile(AbstractMediaInterface &$entity, string $url, string $name)
    {
        $ext = mb_substr($url, mb_strrpos($url, '.') + 1);
        $fileName = str_replace('/', '_', $name) . '.' . $ext;
        $tempFile = $this->kernelRootDir . '/public/uploads/_temp/' . $fileName;
        try {
            $this->filesystem->dumpFile(
                $tempFile,
                file_get_contents($url)
            );
            $entity->setImageFile(
                new UploadedFile(
                    $tempFile,
                    $fileName,
                    mime_content_type($tempFile),
                    null,
                    true
                )
            );
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
        }
    }
}
