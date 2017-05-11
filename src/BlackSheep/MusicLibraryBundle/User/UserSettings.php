<?php

namespace BlackSheep\MusicLibraryBundle\User;

/**
 *
 */
class UserSettings
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var \DateTime
     */
    protected $lastImport;

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set lastImport.
     *
     * @param \DateTime $lastImport
     *
     * @return $this
     */
    public function setLastImport($lastImport)
    {
        $this->lastImport = $lastImport;

        return $this;
    }

    /**
     * Get lastImport.
     *
     * @return \DateTime
     */
    public function getLastImport()
    {
        return $this->lastImport;
    }
}
