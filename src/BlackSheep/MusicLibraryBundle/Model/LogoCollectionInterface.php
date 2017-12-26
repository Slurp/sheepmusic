<?php
namespace BlackSheep\MusicLibraryBundle\Model;

use BlackSheep\MusicLibraryBundle\Model\Media\LogoInterface;

/**
 * Interface LogoCollectionInterface
 *
 * @package BlackSheep\MusicLibraryBundle\Model
 */
interface LogoCollectionInterface
{
    /**
     * @return LogoInterface[]
     */
    public function getLogos();

    /**
     * @param LogoInterface[] $logos
     *
     * @return AlbumInterface
     */
    public function setLogos($logos);

    /**
     * @param LogoInterface $logo
     *
     * @return AlbumInterface
     */
    public function addLogo(LogoInterface $logo);

    /**
     * @param LogoInterface $logo
     *
     * @return $this
     */
    public function removeLogo(LogoInterface $logo);
}
