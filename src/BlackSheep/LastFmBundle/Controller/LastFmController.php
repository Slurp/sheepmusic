<?php

namespace BlackSheep\LastFmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
class LastFmController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $auth = $this->get('black_sheep.last_fm.auth');
        $user = $this->getUser();
        if ($this->getUser()->getLastFmToken() == "") {
            $lastFmLogin = [
                'token' => $auth->getToken(),
                'key' => $auth->getApiKey()
            ];
            $user->setLastFmToken($lastFmLogin['token']);
            $this->get('doctrine.orm.default_entity_manager')->flush($user);
            return $this->render('BlackSheepLastFmBundle:LastFm:index.html.twig', $lastFmLogin);
        }
        try {
            $auth->getSession($user);
            $this->get('doctrine.orm.default_entity_manager')->flush($user);
            $request->getSession()
                ->getFlashBag()
                ->add('success', $this->get('translator')->trans('lastfm.session.success'));
            ;
            return $this->redirectToRoute('homepage');
        } catch (\Exception $e) {
            $user->setLastFmToken('');
            $this->get('doctrine.orm.default_entity_manager')->flush($user);
            $request->getSession()
                ->getFlashBag()
                ->add('error', $e->getMessage());
            return $this->redirectToRoute('black_sheep_last_fm_homepage');
        }
    }
}
