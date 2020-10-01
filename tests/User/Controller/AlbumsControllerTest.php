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

class AlbumsControllerTest extends ApiTestCaseBase
{
    public function testGETAlbumsForUser()
    {
        $token = $this->getToken();
        static::$staticClient->request(
            'GET',
            '/api/album_list',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $token, ]
        );

        $content = static::$staticClient->getResponse()->getContent();
        $this->assertSame(200, static::$staticClient->getResponse()->getStatusCode());
        $this->assertSame([], json_decode($content, true));
    }

    public function testGETAlbumsForUserRefreshToken()
    {
        $token = $this->refreshedToken();
        static::$staticClient->request(
            'GET',
            '/api/album_list',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer ' . $token, ]
        );

        $content = static::$staticClient->getResponse()->getContent();
        $this->assertSame(200, static::$staticClient->getResponse()->getStatusCode());
        $this->assertSame([], json_decode($content, true));
    }

    public function testGETAlbumsAsUnauthorizedUser()
    {
        static::$staticClient->request(
            'GET',
            '/api/album_list',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertSame(403, static::$staticClient->getResponse()->getStatusCode());
        $this->assertSame('{"status":"403 Forbidden","message":"No token. Missing token! Look for it!"}', static::$staticClient->getResponse()->getContent());
    }
}
