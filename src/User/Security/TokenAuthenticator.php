<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\User\Security;

use BlackSheep\User\Entity\User;
use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Guard\AuthenticatorInterface;

/**
 * Class TokenAuthenticator.
 */
class TokenAuthenticator extends AbstractGuardAuthenticator implements AuthenticatorInterface
{
    /**
     * @var JWTEncoderInterface
     */
    private $jwtEncoder;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param JWTEncoderInterface $jwtEncoder
     * @param EntityManager $em
     */
    public function __construct(JWTEncoderInterface $jwtEncoder, EntityManager $em)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        $extractor = new AuthorizationHeaderTokenExtractor(
            'Bearer',
            'Authorization'
        );

        $token = $extractor->extract($request);

        if (!$token) {
            return false;
        }

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $data = $this->jwtEncoder->decode($credentials);

        if ($data === false) {
            throw new CustomUserMessageAuthenticationException('Invalid Token');
        }

        $username = $data['username'];

        return $this->em
            ->getRepository(User::class)
            ->findOneBy(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response('Token missing or invalid', '401');
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new Response('Token is missing!', Response::HTTP_UNAUTHORIZED);
    }
}
