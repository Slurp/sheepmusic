<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFmBundle\Controller\Api;

use BlackSheep\LastFmBundle\Entity\LastFmUserEmbed;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiLastFmController.
 */
class ApiLastFmController extends Controller
{
    /**
     * @Route("/lastfm/token/{refresh}", name="lastfm_token")
     *
     * @param bool $refresh
     *
     * @return Response
     */
    public function getToken($refresh = false): Response
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
    public function connect(): Response
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
    public function disconnect($token): Response
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
