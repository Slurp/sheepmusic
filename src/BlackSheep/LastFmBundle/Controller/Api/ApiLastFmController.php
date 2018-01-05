<?php

namespace BlackSheep\LastFmBundle\Controller\Api;

use BlackSheep\LastFmBundle\Entity\LastFmUserEmbed;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiLastFmController extends Controller
{
    /**
     * @Route("/lastfm/token/{refresh}", name="lastfm_token")
     *
     * @param bool $refresh
     *
     * @return Response
     */
    public function getTokenAction($refresh = false)
    {
        $theUser = $this->getUser();
        if ($theUser instanceof LastFmUserEmbed) {
            return $this->json(
                $this->get('black_sheep.last_fm.auth')->tokenForUser($theUser, $refresh)
            );
        }

        return new JsonResponse(null, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @Route("/lastfm/connect", name="lastfm_connect")
     *
     * @return Response
     */
    public function connectAction()
    {
        $theUser = $this->getUser();
        if ($theUser instanceof LastFmUserEmbed && $theUser->getLastFm()->hasLastFmConnected() === false) {
            try {
                $this->get('black_sheep.last_fm.auth')->sessionForUser($theUser);

                return new JsonResponse(['connected' => true]);
            } catch (\Exception $e) {
                return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
            }
        }

        return new JsonResponse(null, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @Route("/lastfm/disconnect/{token}", name="lastfm_disconnect")
     *
     * @param $token
     *
     * @return Response
     */
    public function disconnectAction($token)
    {
        $theUser = $this->getUser();
        if ($theUser instanceof LastFmUserEmbed) {
            return $this->json(
                ['disconnected' => $this->get('black_sheep.last_fm.auth')->disconnectUser($theUser, $token)]
            );
        }

        return new JsonResponse(null, Response::HTTP_UNAUTHORIZED);
    }
}
