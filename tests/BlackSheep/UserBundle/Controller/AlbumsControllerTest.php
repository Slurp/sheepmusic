<?php

namespace Tests\BlackSheep\UserBundle\Controller;

/**
 *
 */
class AlbumsControllerTest extends ApiTestCaseBase
{
    /**
     *
     */
    public function testGETAlbumsForUser()
    {
        $token = $this->getTokenForTestUser();

        $this->client->request(
            'GET',
            '/api/albums',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer '.$token],
            []
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $content = $this->client->getResponse()->getContent();
        $this->assertEquals([], json_decode($content, true));
    }

    /**
     *
     */
    public function testGETAlbumsAsUnauthorizedUser()
    {
        $this->client->request(
            'GET',
            '/api/albums',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            []
        );

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
        $this->assertEquals('Token is missing!', $this->client->getResponse()->getContent());
    }

    /**
     * Creates some user and returns his token
     *
     * @return string
     */
    private function getTokenForTestUser()
    {
        $userName = "drle_torca";
        $password = "huligan_kola";

        $user = $this->createUser($userName, $password);

        $token = $this->getService('lexik_jwt_authentication.encoder')
                ->encode(['username' => 'drle_torca']);

        return $token;
    }
}
