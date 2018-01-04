<?php

namespace Tests\BlackSheep\UserBundle\Controller;

/**
 *
 */
class LoginControllerTest extends ApiTestCaseBase
{
    /**
     *
     */
    public function testPOSTLoginUser()
    {
        $userName = "mate.misho";
        $password = "ja_sam_Dalmatino_1950";

        $this->createUser($userName, $password);
        $parameter = '{"username":"' . $userName . '","password":"' . $password . '"}';
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
        $reponse = $this->client->getResponse();
        $content = $reponse->getContent();
        $responseArr = json_decode($content, true);
        $this->assertEquals(200, $reponse->getStatusCode());

        $this->assertArrayHasKey('token', $responseArr);
        $this->assertArrayHasKey('refresh_token', $responseArr);
    }

    /**
     *
     */
    public function testPOSTLoginUserWithWrongUsername()
    {
        $userName = "mate.misho";
        $password = "ja_sam_Dalmatino_1950";

        $user = $this->createUser($userName, $password);

        $parameter = '{"username":"'.$userName.'_nope","password":"'.$password.'"}';
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

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
        $responseArr = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals( 'Bad credentials', $responseArr['message']);
    }
}
