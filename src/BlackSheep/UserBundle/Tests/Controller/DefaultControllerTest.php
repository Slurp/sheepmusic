<?php

namespace BlackSheep\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }
}
