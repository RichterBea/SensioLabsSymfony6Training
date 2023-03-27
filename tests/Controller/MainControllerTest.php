<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
/**    private static KernelBrowser $client;

    public static function setUpBeforeClass(): void
    {
        static::$client = static::createClient();
    }
*/
    /**
     * @dataProvider provideMethodsAndUrls
     */
    public function testPublicUrlsAreOk(string $method, string $url): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        // this will produce a failed test:
        //$this->assertResponseStatusCodeSame(302);
    }

    public function provideMethodsAndUrls(): \Generator
    {
        yield 'home' => ['GET', '/'];
        yield 'contact' => ['GET', '/contact'];
        yield 'movie_index' => ['GET', '/movie'];
        yield ['GET', '/movie/show'];
        yield ['GET', '/movie/show'];
        yield ['GET', '/hello/Bea'];
    }
}
