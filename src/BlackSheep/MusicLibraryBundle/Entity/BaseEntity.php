<?php
/**
 * @author: Stephan Langeweg <stephan@bureaublauwgeel.nl>
 * Date: 15/02/16
 * Time: 19:31
 * @copyright 2016 Bureau Blauwgeel
 * @version 1.0
 */
namespace BlackSheep\MusicLibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Base for timestampable entities.
 */
abstract class BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
