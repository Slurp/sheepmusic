<?php
/**
 * Created by PhpStorm.
 * User: slangeweg
 * Date: 26/12/2017
 * Time: 01:13
 */

namespace BlackSheep\MusicLibraryBundle\Model\Media;

use BlackSheep\MusicLibraryBundle\Model\ArtistInterface;

/**
 * Class LogoEntity
 *
 * @package BlackSheep\MusicLibraryBundle\Entity\Media
 * @ORM\Table()
 * @ORM\Entity()
 */
interface LogoInterface
{
    /**
     * @return ArtistInterface
     */
    public function getArtist();

    /**
     * @param ArtistInterface $artist
     *
     * @return $this
     */
    public function setArtist(ArtistInterface $artist);

    /**
     * @return int
     */
    public function getLikes();

    /**
     * @param mixed $likes
     */
    public function setLikes($likes);
}
