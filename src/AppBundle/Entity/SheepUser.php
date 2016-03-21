<?php
/**
 * @author: @{USER} <stephan@bureaublauwgeel.nl>
 * Date: 29/02/16
 * Time: 22:06
 * @copyright 2016 Bureau Blauwgeel
 * @version 1.0
 */
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sheep_users")
 */
class SheepUser extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
