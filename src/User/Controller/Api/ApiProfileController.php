<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\User\Controller\Api;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Profile for a user.
 */
class ApiProfileController extends AbstractController
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param UserManagerInterface $userManager
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        UserManagerInterface $userManager
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->userManager = $userManager;
    }

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

    /**
     * @Route("/user/profile", name="get_user_profile")
     *
     * @return Response
     */
    public function profileAction()
    {
        return $this->json(
            $this->getUser()->getApiData()
        );
    }

    /**
     * @Route("/user/save/profile", name="save_user_profile", methods={"PUT", "POST", "PATCH"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->get('fos_user.profile.form.factory')->createForm(['csrf_protection' => false]);
        $form->remove('password');
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleForm($form, $request, $dispatcher, $user);
        }

        if ($form->isSubmitted() && $form->isValid() === false) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[$error->getOrigin()->getName()][] = $error->getMessage();
            }

            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['formName' => $form->getName()]);
    }

    /**
     * @param FormInterface $form
     * @param Request $request
     * @param EventDispatcherInterface $dispatcher
     * @param UserInterface $user
     *
     * @return null|RedirectResponse|Response
     */
    protected function handleForm(FormInterface $form, Request $request, EventDispatcherInterface $dispatcher, $user)
    {
        $userManager = $this->get('fos_user.user_manager');

        $event = new FormEvent($form, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

        $userManager->updateUser($user);
        $response = $event->getResponse();
        if (null === $response) {
            $response = new JsonResponse($user);
        }

        $dispatcher->dispatch(
            FOSUserEvents::PROFILE_EDIT_COMPLETED,
            new FilterUserResponseEvent($user, $request, $response)
        );

        return $response;
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
