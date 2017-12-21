<?php

namespace BlackSheep\UserBundle\Controller\Api;

use BlackSheep\UserBundle\Helper\ControllerHelper;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Services\EmailConfirmation\EmailUpdateConfirmation;
use JMS\Serializer\SerializerBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Profile for a user
 */
class ApiProfileController extends AbstractController
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var FactoryInterface
     */
    private $formFactory;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var EmailUpdateConfirmation
     */
    private $emailUpdateConfirmation;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param FactoryInterface $formFactory
     * @param UserManagerInterface $userManager
     * @param EmailUpdateConfirmation $emailUpdateConfirmation
     * @param TranslatorInterface $translator
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        FactoryInterface $formFactory,
        UserManagerInterface $userManager,
        EmailUpdateConfirmation $emailUpdateConfirmation,
        TranslatorInterface $translator
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
        $this->userManager = $userManager;
        $this->emailUpdateConfirmation = $emailUpdateConfirmation;
        $this->translator = $translator;
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
     * @param Request $request
     *
     * @return null|RedirectResponse|Response
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->get('fos_user.profile.form.factory')->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->handleForm($form, $request, $dispatcher, $user);
        }

        return $this->render(
            '@BlackSheepUser/Profile/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
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
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $event = new FormEvent($form, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

        $userManager->updateUser($user);
        $response = $event->getResponse();
        if (null === $response) {
            $url = $this->generateUrl('fos_user_profile_show');
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(
            FOSUserEvents::PROFILE_EDIT_COMPLETED,
            new FilterUserResponseEvent($user, $request, $response)
        );

        return $response;
    }

    /**
     * {@inheritDoc}
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
