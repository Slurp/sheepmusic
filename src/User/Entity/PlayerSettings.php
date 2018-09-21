<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Settings.
 *
 * @ORM\Embeddable
 */
class PlayerSettings
{
    /**
     * @var bool
     *
     * @ORM\Column(name="has_flac_support", type="boolean", options={"default" = 0})
     */
    protected $hasFlacSupport;

    /**
     * @return bool
     */
    public function hasFlacSupport(): bool
    {
        return $this->hasFlacSupport;
    }

    /**
     * @param bool $hasFlacSupport
     */
    public function setHasFlacSupport(bool $hasFlacSupport): void
    {
        $this->hasFlacSupport = $hasFlacSupport;
    }

    /**
     * @return array
     */
    public function getApiData()
    {
        return [
      'flac' => $this->hasFlacSupport(),
    ];
    }
}
