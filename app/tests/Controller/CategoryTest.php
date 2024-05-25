<?php
/**
 * Tests for Category Controller.
 */
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class CategoryTest.
 */

class CategoryTest extends WebTestCase
{
    /**
     * Tested route
     *
     * @const string
     */
    public const TEST_ROUTE = '/category';

    /**
     * Test client
     */
    private KernelBrowser $httpClient;

    /**
     * Set up tests
     */
    public function setUp(): void
    {
        $this->httpClient = static::createClient();
    }

    /**
     * Login function
     */
    public function login(): void
    {
        $crawler = $this->httpClient->request('GET', '/login');

        $form = $crawler->filter('button.btn-primary')->form([
            'email' => 'admin0@example.com',
            'password' => 'admin1234',
        ]);

        $this->httpClient->submit($form);
        $this->httpClient->followRedirects();
    }

    /**
     * Test route
     */
    public function testRoute(): void
    {
        $expectedStatusCode = 200;
        $this->login();

        $this->httpClient->request('GET', self::TEST_ROUTE);
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }
}