<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\LastFm\Auth;

use BlackSheep\LastFm\Entity\LastFmUserEmbed;
use Doctrine\ORM\EntityManagerInterface;
use LastFmApi\Api\AuthApi;
use LastFmApi\Exception\ApiFailedException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

/**
 * LastFm auth.
 */
class LastFmAuth
{
    /**
     * @var AuthApi
     */
    protected $auth;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecret;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param ContainerBagInterface $containerBag
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ContainerBagInterface $containerBag, EntityManagerInterface $entityManager)
    {
        $this->apiKey = $containerBag->get('black_sheep_music_library.last_fm_api_key');
        $this->apiSecret = $containerBag->get('black_sheep_music_library.last_fm_api_secret');
        $this->entityManager = $entityManager;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param LastFmUserEmbed $user
     * @param bool $refresh
     *
     * @return array
     * @throws \LastFmApi\Exception\InvalidArgumentException
     */
    public function tokenForUser(LastFmUserEmbed $user, $refresh = false)
    {
        if(!empty($this->apiSecret)) {
            if ($refresh || $user->getLastFm()->getLastFmToken() === '' || $user->getLastFm()->getLastFmToken(
                ) === null) {
                $auth = new AuthApi(
                    'gettoken',
                    ['apiKey' => $this->apiKey, 'apiSecret' => $this->apiSecret]
                );
                $user->getLastFm()->setLastFmToken((string) $auth->token);
                $this->entityManager->flush();
            }
            if ($user->getLastFm()->hasLastFmConnected() === false) {
                return [
                    'lastfm_token' => $user->getLastFm()->getLastFmToken(),
                    'key' => $this->getApiKey(),
                ];
            }
        }

        return [];
    }

    /**
     * @param LastFmUserEmbed $user
     * @param $token
     *
     * @return bool
     */
    public function disconnectUser(LastFmUserEmbed $user, $token)
    {
        $disconnected = $user->getLastFm()->disconnect($token);
        $this->entityManager->flush();

        return $disconnected;
    }

    /**
     * @param LastFmUserEmbed $user
     *
     * @throws ApiFailedException
     * @throws \Exception
     */
    public function sessionForUser(LastFmUserEmbed $user)
    {
        $authArray = ['apiKey' => $this->apiKey, 'apiSecret' => $this->apiSecret];
        $authArray['token'] = $user->getLastFm()->getLastFmToken();
        try {
            $auth = new AuthApi('getsession', $authArray);
            if ($auth === false) {
                throw new ApiFailedException('NOOOOO!!! Something has failed us');
            }
            $user->getLastFm()->setLastFmKey($auth->sessionKey);
            $user->getLastFm()->setLastFmUserName($auth->username);
            $user->getLastFm()->setLastFmSubscriber($auth->subscriber);
            $this->entityManager->flush();
        } catch (ApiFailedException $exception) {
            $this->resetLastFmUser($user);
            throw $exception;
        }
    }

    /**
     * @param LastFmUserEmbed $user
     */
    private function resetLastFmUser(LastFmUserEmbed $user)
    {
        $user->getLastFm()->setLastFmKey('');
        $user->getLastFm()->setLastFmUserName('');
        $user->getLastFm()->setLastFmSubscriber(false);
        $user->getLastFm()->setLastFmToken('');
        $this->entityManager->flush();
    }
}
