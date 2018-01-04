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
        $token = $this->getToken();
        $this->client->request(
            'GET',
            '/api/album_list',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer '.$token],
            []
        );

        $content = $this->client->getResponse()->getContent();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals([], json_decode($content, true));
    }

    /**
     *
     */
    public function testGETAlbumsForUserRefreshToken()
    {
        $token = $this->refreshedToken();
        $this->client->request(
            'GET',
            '/api/album_list',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer '.$token],
            []
        );

        $content = $this->client->getResponse()->getContent();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals([], json_decode($content, true));
    }

    /**
     *
     */
    public function testGETAlbumsAsUnauthorizedUser()
    {
        $this->client->request(
            'GET',
            '/api/album_list',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            []
        );

        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
        $this->assertEquals('{"status":"403 Forbidden","message":"No token. Missing token! Look for it!"}', $this->client->getResponse()->getContent());
    }
}
