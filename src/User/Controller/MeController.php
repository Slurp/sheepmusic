<?php

namespace BlackSheep\User\Controller;

use BlackSheep\User\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class MeController extends AbstractController
{
    /**
     * @var Security
     */
    protected Security $security;

    /**
     * IntrospectionController constructor.
     *
     * @param Security $security
     */
    public function __construct(Security $security)
    {

        $this->security = $security;
    }

    /**
     * @Route(name="user_get", path="user", methods={"GET"})
     * @return JsonResponse
     */
    public function getAction()
    {
        $user = $this->security->getUser();

        if (!$user instanceof UserInterface) {
            throw new AccessDeniedException();
        }

        return new JsonResponse(
            [
                'id' => $user->getId(),
            ]
        );
    }
}
