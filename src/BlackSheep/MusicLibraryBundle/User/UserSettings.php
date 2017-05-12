<?php

namespace BlackSheep\MusicLibraryBundle\User;

/**
 * Settings
 * Settings which are loaded from config adn updated from the system.
 */
class UserSettings implements UserSettingsInterface
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
     * {@inheritdoc}
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastImport($lastImport)
    {
        $this->lastImport = $lastImport;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastImport()
    {
        return $this->lastImport;
    }
}
