<?php

namespace BlackSheep\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings.
 *
 * @ORM\Embeddable()
 */
class Settings
{
    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    protected $path;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastImport", type="datetime", nullable=true)
     */
    protected $lastImport;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return \DateTime
     */
    public function getLastImport()
    {
        return $this->lastImport;
    }

    /**
     * @return array
     */
    public function getApiData()
    {
        return [
            'path' => $this->getPath(),
            'last_import' => $this->getLastImport(),
        ];
    }
}
