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
        if ($this->getUser()->getLastFmToken() !== "") {
            return $this->render(
                'BlackSheepLastFmBundle:LastFm:index.html.twig',
                $auth->tokenForUser($this->getUser())
            );
        }

        try {
            $auth->sessionForUser($this->getUser());
            $request->getSession()
                ->getFlashBag()
                ->add(
                    'success',
                    $this->get('translator')->trans('lastfm.session.success')
                );
            return $this->redirectToRoute('homepage');
        } catch (\Exception $e) {
            $request->getSession()
                ->getFlashBag()
                ->add('error', $e->getMessage());
            return $this->redirectToRoute('black_sheep_last_fm_homepage');
        }
    }
}
