<?php

/*
 * This file is part of the BlackSheep Music.
 *
 * (c) Stephan Langeweg <slurpie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackSheep\Tests\User\Controller;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ApiTestCaseBase extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected static KernelBrowser $staticClient;

    /**
     * @var ContainerInterface
     */
    protected static $staticContainer;

    public static function setUpBeforeClass(): void
    {
        static::$staticClient = static::createClient(['environment' => 'test']);
        self::$staticContainer = static::$container;

    }

    protected function setUp(): void
    {
        $this->purgeDatabase();
    }

    /**
     * @param $id
     *
     * @return object
     */
    protected function getService($id)
    {
        static::bootKernel();
        return static::$container->get($id);
    }

    /**
     * @param $userName
     * @param $password
     * @param null $addOnEmail
     *
     * @return mixed
     */
    protected function createUser($userName, $password, $addOnEmail = null)
    {
        $userManager = $this->getService('BlackSheep\User\Repository\UserRepository');
        return $userManager->createUser($userName, $password);
    }

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return mixed
     */
    protected function getToken($username = 'user', $password = 'password')
    {
        $this->createUser($username, $password);
        $parameter = '{"username":"' . $username . '","password":"' . $password . '"}';
        static::$staticClient->request(
            'POST',
            '/api/login_check',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            $parameter
        );

        $response = static::$staticClient->getResponse()->getContent();
        $data = json_decode($response, true);

        return $data['token'];
    }

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function refreshedToken($username = 'user', $password = 'password')
    {
        $this->createUser($username, $password);
        $parameter = '{"username":"' . $username . '","password":"' . $password . '"}';
        static::$staticClient->request(
            'POST',
            '/api/login_check',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            $parameter
        );

        $response = static::$staticClient->getResponse()->getContent();
        $data = json_decode($response, true);

        static::$staticClient->request(
            'GET',
            '/api/token/refresh?refresh_token=' . $data['refresh_token']
        );
        $refreshReponse = static::$staticClient->getResponse()->getContent();
        $refreshData = json_decode($refreshReponse, true);

        return $refreshData['token'];
    }

    private function purgeDatabase()
    {
        $purger = new ORMPurger($this->getService('doctrine')->getManager());
        $purger->purge();
    }
}
