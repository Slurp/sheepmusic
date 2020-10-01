<?php

namespace BlackSheep\User\Controller;

use BlackSheep\User\Entity\User;
use BlackSheep\User\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class MeController extends AbstractController
{
    /**
     * @var User|null
     */
    protected ?User $user;

    /**
     * IntrospectionController constructor.
     *
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->user = $security->getUser();

        if (!$this->user instanceof UserInterface) {
            throw new AccessDeniedException();
        }
    }

    /**
     * @Route(name="user_get", path="user", methods={"GET"})
     * @return JsonResponse
     */
    public function getAction()
    {
        return new JsonResponse(
            [
                'id' => $this->user->getId(),
            ]
        );
    }

    /**
     * @Route(name="user_profile", path="user/profile", methods={"GET"})
     * @return JsonResponse
     */
    public function profileAction()
    {
        return new JsonResponse($this->user->getApiData());
    }
}
