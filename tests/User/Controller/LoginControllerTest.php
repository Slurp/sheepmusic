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

class LoginControllerTest extends ApiTestCaseBase
{
    public function testPOSTLoginUser()
    {
        $userName = 'mate.misho';
        $password = 'ja_sam_Dalmatino_1950';

        $this->createUser($userName, $password);
        $parameter = '{"username":"' . $userName . '","password":"' . $password . '"}';
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
        $reponse = static::$staticClient->getResponse();
        $content = $reponse->getContent();
        $responseArr = json_decode($content, true);
        $this->assertSame(200, $reponse->getStatusCode());

        $this->assertArrayHasKey('token', $responseArr);
        $this->assertArrayHasKey('refresh_token', $responseArr);
    }

    public function testPOSTLoginUserWithWrongUsername()
    {
        $userName = 'mate.misho';
        $password = 'ja_sam_Dalmatino_1950';

        $user = $this->createUser($userName, $password);

        $parameter = '{"username":"' . $userName . '_nope","password":"' . $password . '"}';
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

        $this->assertSame(401, static::$staticClient->getResponse()->getStatusCode());
        $responseArr = json_decode(static::$staticClient->getResponse()->getContent(), true);
        $this->assertSame('Invalid credentials.', $responseArr['message']);
    }
}
