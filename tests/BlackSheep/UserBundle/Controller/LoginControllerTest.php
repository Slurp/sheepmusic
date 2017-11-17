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
        $parameter = '{"username":"'.$userName.'","password":"'.$password.'"}';
        $this->client->request(
            'POST',
            '/api/login',
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
    }

    /**
     *
     */
    public function testPOSTLoginUserWitAddOnEmail()
    {
        $userName = "mate@misho.com";
        $password = "ja_sam_Dalmatino_1950";
        $addOnEmail = "majlo.hrnic@du.hr";

        $user = $this->createUser($userName, $password, $addOnEmail);

        $parameter = '{"username":"'.$addOnEmail.'","password":"'.$password.'"}';
        $this->client->request(
            'POST',
            '/api/login',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            $parameter
        );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $responseArr = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $responseArr);
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
            '/api/login',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            $parameter
        );

        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $responseArr = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Not Found', $responseArr['error']['message']);
    }
}
