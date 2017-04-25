<?php

namespace BlackSheep\LastFmBundle\Controller;

use BlackSheep\LastFmBundle\Entity\LastFmUserEmbed;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
class LastFmController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function indexAction(Request $request)
    {
        $theUser = $this->getUser();
        if ($theUser instanceof LastFmUserEmbed) {
            $auth = $this->get('black_sheep.last_fm.auth');
            if ($theUser->getLastFm()->getLastFmToken() === "" || $theUser->getLastFm()->getLastFmToken() === null) {
                return $this->render(
                    'BlackSheepLastFmBundle:LastFm:index.html.twig',
                    $auth->tokenForUser($theUser)
                );
            }
            if ($theUser->getLastFm()->hasLastFmConnected() === false) {
                try {
                    $auth->sessionForUser($theUser);
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
            return $this->render(
                'BlackSheepLastFmBundle:LastFm:index.html.twig',
                ['user' => $theUser]
            );
        }
        return $this->redirect('/');
    }
}
