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

use BlackSheep\LastFm\Entity\Embeddable\LastFmUser;
use BlackSheep\MusicLibrary\User\UserSettings;
use Doctrine\ORM\Mapping as ORM;
use BlackSheep\User\Model\SheepUser as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="sheep_users")
 */
class SheepUser extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var LastFmUser
     * @ORM\Embedded(class="BlackSheep\LastFm\Entity\Embeddable\LastFmUserEmbeddable", columnPrefix=false)
     */
    protected $lastFm;

    /**
     * @var UserSettings
     * @ORM\Embedded(class="BlackSheep\User\Entity\Settings", columnPrefix=false)
     */
    protected $settings;

    /**
     * @var PlayerSettings
     * @ORM\Embedded(class="BlackSheep\User\Entity\PlayerSettings", columnPrefix=false)
     */
    protected $playerSettings;
}
