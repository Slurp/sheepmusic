<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\User\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTFailureEventInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class JWTExpiredListener.
 */
class JWTExpiredListener
{
    /**
     * @param JWTFailureEventInterface $event
     */
    public function onJWTExpired(JWTFailureEventInterface $event)
    {
        /** @var JWTAuthenticationFailureResponse */
        $response = $event->getResponse();
        $response->setStatusCode(498);
        $response->setContent('Your token is expired, please renew it.');
    }

    /**
     * @param JWTFailureEventInterface $event
     */
    public function onJWTInvalid(JWTFailureEventInterface $event)
    {
        $response = new JWTAuthenticationFailureResponse(
            'Your token is invalid, please login again to get a new one',
            403
        );

        $event->setResponse($response);
    }

    /**
     * @param JWTFailureEventInterface $event
     */
    public function onJWTNotFound(JWTFailureEventInterface $event)
    {
        $data = [
            'status' => '403 Forbidden',
            'message' => 'No token. Missing token! Look for it!',
        ];

        $response = new JsonResponse($data, 403);

        $event->setResponse($response);
    }
}
