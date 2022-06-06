<?php


namespace App\Tests\Functional;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    public function testCart(): void
    {
        $client = self::createClient();
        $client->enableProfiler();

        $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testPayments(): void
    {
        $client = self::createClient();
        $client->enableProfiler();

        $client->request('GET', '/payment');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
