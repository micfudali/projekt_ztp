<?php

/**
 * This test file is a part of project made as a part of the ZTP course completion.
 *
 * (c) Michał Fudali <michal.fudali@student.uj.edu.pl>
 */

namespace App\Tests\Controller;

use App\Entity\Category;
use App\Entity\Enum\UserRole;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\PostService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PostControllerTest.
 */
class PostControllerTest extends WebTestCase
{
    /**
     * Test route.
     *
     * @const string
     */
    public const TEST_ROUTE = '/post';

    /**
     * Test client.
     */
    private KernelBrowser $httpClient;

    /**
     * Post repository.
     */
    private ?EntityManagerInterface $entityManager;

    /**
     * Set up tests.
     */
    public function setUp(): void
    {
        $this->httpClient = static::createClient();
        $container = static::getContainer();
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
        $this->categoryService = $container->get(PostService::class);
    }

    /**
     * Test index route for anonymous user.
     */
    public function testIndexRouteAnonymousUser(): void
    {
        // given
        $expectedStatusCode = 200;

        // when
        $this->httpClient->request('GET', self::TEST_ROUTE);
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Test index route for admin user.
     *
     * @throws ContainerExceptionInterface|NotFoundExceptionInterface|ORMException|OptimisticLockException
     */
    public function testIndexRouteAdminUser(): void
    {
        // given
        $expectedStatusCode = 200;
        $adminUser = $this->createUser([UserRole::ROLE_USER->value, UserRole::ROLE_ADMIN->value]);
        $this->httpClient->loginUser($adminUser);

        // when
        $this->httpClient->request('GET', self::TEST_ROUTE);
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Test index route for non-authorized user.
     *
     * @throws ContainerExceptionInterface|NotFoundExceptionInterface|ORMException|OptimisticLockException
     */
    public function testIndexRouteNonAuthorizedUser(): void
    {
        // given
        $expectedStatusCode = 200;
        $user = $this->createUser([UserRole::ROLE_USER->value]);
        $this->httpClient->loginUser($user);

        // when
        $this->httpClient->request('GET', self::TEST_ROUTE);
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Test create route for anonymous user.
     */
    public function testCreateRouteAnonymousUser(): void
    {
        // given
        $expectedStatusCode = 302;

        // when
        $this->httpClient->request('GET', self::TEST_ROUTE.'/create');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Test create route for admin user.
     *
     * @throws ContainerExceptionInterface|NotFoundExceptionInterface|ORMException|OptimisticLockException
     */
    public function testCreateRouteAdminUser(): void
    {
        // given
        $expectedStatusCode = 200;
        $adminUser = $this->createUser([UserRole::ROLE_USER->value, UserRole::ROLE_ADMIN->value]);
        $this->httpClient->loginUser($adminUser);

        // when
        $this->httpClient->request('GET', self::TEST_ROUTE.'/create');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Test create route for non-authorized user.
     *
     * @throws ContainerExceptionInterface|NotFoundExceptionInterface|ORMException|OptimisticLockException
     */
    public function testCreateRouteNonAuthorizedUser(): void
    {
        // given
        $expectedStatusCode = 403;
        $user = $this->createUser([UserRole::ROLE_USER->value]);
        $this->httpClient->loginUser($user);

        // when
        $this->httpClient->request('GET', self::TEST_ROUTE.'/create');
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Test show for anonymous user.
     */
    public function testShowRouteAnonymousUser(): void
    {
        // given
        $expectedStatusCode = 200;

        $category = new Category();
        $category->setTitle('Test Category');
        $user = $this->createUser(['ROLE_ADMIN']);
        $date = new \DateTimeImmutable();
        $post = new Post();
        $post->setTitle('Test Post');
        $post->setContents('Lorem ipsum dolor sit amet');
        $post->setCategory($category);
        $post->setAuthor($user);
        $post->setCreatedAt($date);

        $this->entityManager->persist($category);
        $this->entityManager->flush();
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        // when
        $this->httpClient->request('GET', self::TEST_ROUTE.'/'.$post->getId());
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Test show route for admin user.
     *
     * @throws ContainerExceptionInterface|NotFoundExceptionInterface|ORMException|OptimisticLockException
     */
    public function testShowRouteAdminUser(): void
    {
        // given
        $expectedStatusCode = 200;

        $category = new Category();
        $category->setTitle('Test Category');
        $user = $this->createUser(['ROLE_ADMIN']);
        $date = new \DateTimeImmutable();
        $post = new Post();
        $post->setTitle('Test Post');
        $post->setContents('Lorem ipsum dolor sit amet');
        $post->setCategory($category);
        $post->setAuthor($user);
        $post->setCreatedAt($date);

        $this->entityManager->persist($category);
        $this->entityManager->flush();
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        // when
        $this->httpClient->request('GET', self::TEST_ROUTE.'/'.$post->getId());
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Test create route for non-authorized user.
     *
     * @throws ContainerExceptionInterface|NotFoundExceptionInterface|ORMException|OptimisticLockException
     */
    public function testShowRouteNonAuthorizedUser(): void
    {
        // given
        $expectedStatusCode = 200;

        $category = new Category();
        $category->setTitle('Test Category');
        $user = $this->createUser(['ROLE_ADMIN']);
        $date = new \DateTimeImmutable();
        $post = new Post();
        $post->setTitle('Test Post');
        $post->setContents('Lorem ipsum dolor sit amet');
        $post->setCategory($category);
        $post->setAuthor($user);
        $post->setCreatedAt($date);

        $this->entityManager->persist($category);
        $this->entityManager->flush();
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        // when
        $this->httpClient->request('GET', self::TEST_ROUTE.'/'.$post->getId());
        $resultStatusCode = $this->httpClient->getResponse()->getStatusCode();

        // then
        $this->assertEquals($expectedStatusCode, $resultStatusCode);
    }

    /**
     * Create user.
     *
     * @param array $roles User roles
     *
     * @return User User entity
     *
     * @throws ContainerExceptionInterface|NotFoundExceptionInterface|ORMException|OptimisticLockException
     */
    private function createUser(array $roles): User
    {
        $passwordHasher = static::getContainer()->get('security.password_hasher');
        $user = new User();
        $user->setEmail('user@example.com');
        $user->setRoles($roles);
        $user->setPassword(
            $passwordHasher->hashPassword(
                $user,
                'p@55w0rd'
            )
        );
        $userRepository = static::getContainer()->get(UserRepository::class);
        $userRepository->save($user);

        return $user;
    }
}
