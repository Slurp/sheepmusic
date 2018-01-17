<?php
/**
 * Created by PhpStorm.
 * User: slangeweg
 * Date: 26/12/2017
 * Time: 00:22.
 */

namespace BlackSheep\MusicLibraryBundle\Entity\Media;

use Symfony\Component\HttpFoundation\File\File;
use BlackSheep\MusicLibraryBundle\Model\Media\AbstractMediaInterface as Model;

/**
 * Class AbstractMediaClass.
 */
interface AbstractMediaInterface extends Model
{
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @return void
     */
    public function setImageFile(File $image = null);

    /**
     * @return File
     */
    public function getImageFile();
}
