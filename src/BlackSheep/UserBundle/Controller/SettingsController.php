<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\UserBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Profile for a user.
 */
class SettingsController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $user = $this->getUser();

        return $this->render('BlackSheepUserBundle:Profile:index.html.twig', ['user' => $user]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getUser()
    {
        $user = parent::getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $user;
    }
}
