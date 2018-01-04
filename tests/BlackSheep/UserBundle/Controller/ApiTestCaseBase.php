<?php

namespace Tests\BlackSheep\UserBundle\Controller;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTestCaseBase extends WebTestCase
{
    /**
     * @var $staticClient Client
     */
    protected static $staticClient;

    /**
     * @var $staticClient Client
     */
    protected $client;

    /**
     *
     */
    public static function setUpBeforeClass()
    {
        self::$staticClient = static::createClient(['environment' => 'test']);

        // kernel boot, so we can get the container and use our services
        self::bootKernel();
    }

    /**
     *
     */
    protected function setUp()
    {
        $this->client = self::$staticClient;
        $this->purgeDatabase();
    }

    /**
     *
     */
    protected function tearDown()
    {
        // purposefully not calling parent class, which shuts down the kernel
    }

    /**
     * @param $id
     *
     * @return object
     */
    protected function getService($id)
    {
        return self::$kernel->getContainer()
            ->get($id);
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
        $userManager = $this->getService('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setEnabled(true);
        $user->setPlainPassword($password);
        $user->setUsername($userName);
        $user->setEmail('email@email.com');
        $user->setEnabled(true);
        $userManager->updateUser($user);

        if (null !== $addOnEmail) {
            $user->addEmail($addOnEmail);
            $userManager->updateUser($user);
        }

        return $user;
    }

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function getToken($username = 'user', $password = 'password')
    {
        $this->createUser($username, $password);
        $parameter = '{"username":"' . $username . '","password":"' . $password . '"}';
        $this->client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            $parameter
        );

        $response = $this->client->getResponse()->getContent();
        $data = json_decode($response, true);

        return $data['token'];
    }

    /**
     *
     */
    private function purgeDatabase()
    {
        $purger = new ORMPurger($this->getService('doctrine')->getManager());
        $purger->purge();
    }
}
