<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibraryBundle\Factory\Media;

use BlackSheep\MusicLibraryBundle\Entity\Media\AbstractMediaInterface;
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
     */
    public function __construct(UploadHandler $uploadHandler, $kernelRootDir)
    {
        $this->uploadHandler = $uploadHandler;
        $this->kernelRootDir = $kernelRootDir;
    }

    /**
     * @param AbstractMediaInterface $entity
     * @param string                 $url
     * @param string                 $name
     */
    public function copyExternalFile(AbstractMediaInterface &$entity, string $url, string $name)
    {
        $ext = mb_substr($url, mb_strrpos($url, '.') + 1);
        $tempFile = $this->kernelRootDir . '/../web/uploads/_temp.' . $name . '.' . $ext;
        if (@copy($url, $tempFile)) {
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
