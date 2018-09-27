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
     * @var
     */
    protected $kernelRootDir;

    /**
     * AbstractMediaFactory constructor.
     *
     * @param UploadHandler $uploadHandler
     * @param $projectDir
     */
    public function __construct(UploadHandler $uploadHandler, string $projectDir)
    {
        $this->uploadHandler = $uploadHandler;
        $this->kernelRootDir = $projectDir;
    }

    /**
     * @param AbstractMediaInterface $entity
     * @param string                 $url
     * @param string                 $name
     */
    public function copyExternalFile(AbstractMediaInterface &$entity, string $url, string $name)
    {
        $ext = mb_substr($url, mb_strrpos($url, '.') + 1);
        $tempFile = $this->kernelRootDir . '/public/uploads/_temp/' . str_replace('/', '_', $name) . '.' . $ext;
        if (copy($url, $tempFile)) {
            $entity->setImageFile(
                new UploadedFile(
                    $tempFile,
                    uniqid($name, true) . '.' . $ext,
                    mime_content_type($tempFile),
                    filesize($tempFile),
                    null,
                    true
                )
            );
            $this->uploadHandler->upload($entity, 'imageFile');
        } else {
            @unlink($tempFile);
        }
    }
}
