<?php

namespace BlackSheep\MusicLibraryBundle\Traits;

use BlackSheep\MusicLibraryBundle\Model\Media\LogoInterface;

/**
 * Trait LogoCollectionTrait
 *
 * @package BlackSheep\MusicLibraryBundle\Traits
 */
trait LogoCollectionTrait
{
    /**
     * @var LogoInterface[]
     */
    protected $logos;

    /**
     * @return LogoInterface[]
     */
    public function getLogos()
    {
        return $this->logos;
    }

    /**
     * {@inheritdoc}
     */
    public function setLogos($logos)
    {
        $this->logos = $logos;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addLogo(LogoInterface $logo)
    {
        if (in_array($logo, $this->logos) === false) {
            $this->logos[] = $logo;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeLogo(LogoInterface $logo)
    {
        if (($key = array_search($logo, $this->logos, true)) !== false) {
            unset($this->logos[$key]);
            $this->logos = array_values($this->logos);
        }

        return $this;
    }
}
