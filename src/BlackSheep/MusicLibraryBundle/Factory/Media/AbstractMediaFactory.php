<?php
/**
 * Created by PhpStorm.
 * User: slangeweg
 * Date: 26/12/2017
 * Time: 00:12
 */

namespace BlackSheep\MusicLibraryBundle\Factory\Media;

use BlackSheep\MusicLibraryBundle\Entity\Media\AbstractMediaInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Handler\UploadHandler;

/**
 * Class AbstractMediaFactory
 *
 * @package BlackSheep\MusicLibraryBundle\Factory\Media
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
     * @param $url
     * @param $name
     */
    public function copyExternalFile(AbstractMediaInterface &$entity, $url, $name)
    {
        $ext = substr($url, strrpos($url, ".") + 1);
        $tempFile = $this->kernelRootDir . '/../web/uploads/_temp.' . $name . '.' . $ext;
        copy($url, $tempFile);
        $entity->setImageFile(
            new UploadedFile(
                $tempFile,
                $name . '.' . $ext,
                mime_content_type($tempFile),
                filesize($tempFile),
                null,
                true
            )
        );
        $this->uploadHandler->upload($entity, 'imageFile');
        //unlink($tempFile);
    }
}
