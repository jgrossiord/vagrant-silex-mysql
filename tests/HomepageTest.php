<?php

use Silex\WebTestCase;

class HomepageTest extends WebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__.'/../src/controllers/main.php';
        //$app['debug'] = true;
        //$app['exception_handler']->disable();
        return $app;
    }

    public function testGetIndex()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testGetUsers()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/users');
        $this->assertTrue($client->getResponse()->isOk());
    }

    public function testGetUser()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/users/1');
        $this->assertTrue($client->getResponse()->isOk());
    }

}
?>
