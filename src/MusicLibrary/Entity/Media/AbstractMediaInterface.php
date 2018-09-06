<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\MusicLibrary\Entity\Media;

use BlackSheep\MusicLibrary\Model\Media\AbstractMediaInterface as Model;
use Symfony\Component\HttpFoundation\File\File;

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
     */
    public function setImageFile(File $image = null);

    /**
     * @return File
     */
    public function getImageFile();

    /**
     * @return string
     */
    public function getSlug(): string;
}
