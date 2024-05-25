<?php
/**
 * Tests for Security Controller.
 */
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SecurityTest.
 */

class SecurityTest extends WebTestCase
{
    /**
     * Tested route
     *
     * @const string
     */
    public const TEST_ROUTE = '/login';

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
     * Test route
     */
    public function testRoute(): void
    {
        $expectedStatusCode = 200;

        $this->httpClient->request('GET', self::TEST_ROUTE);
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }
}