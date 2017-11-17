<?php

namespace BlackSheep\MusicLibraryBundle\Controller\Api;

use BlackSheep\UserBundle\Helper\ControllerHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class UserApiController extends Controller
{
    use ControllerHelper;

    /**
     * @Route("/user", name="get_user")
     *
     * @return Response
     */
    public function userAction()
    {
        return $this->json(
            ['user' => $this->getUser()->getUserName()]
        );
    }
}
