<?php
/**
 * Post service tests.
 */

namespace App\Tests\Service;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\PostService;
use App\Service\PostServiceInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class PostServiceTest.
 */
class PostServiceTest extends KernelTestCase
{
    /**
     * Post repository.
     */
    private ?EntityManagerInterface $entityManager;

    /**
     * Post service.
     */
    private ?PostServiceInterface $postService;

    /**
     * Set up test.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function setUp(): void
    {
        $container = static::getContainer();
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
        $this->postService = $container->get(PostService::class);
    }

    /**
     * Test save.
     *
     * @throws ORMException
     */
    public function testSave(): void
    {
        // given
        $category = new Category();
        $user = $this->createUser(['ROLE_ADMIN']);
        $expectedPost = new Post();
        $expectedPost->setTitle('Test Post');
        $expectedPost->setContents('Lorem ipsum dolor sit amet');
        $expectedPost->setCategory($category);
        $expectedPost->setAuthor($user);

        $category->setTitle('Test Category');
        $this->entityManager->persist($category);
        $this->entityManager->flush();

        // when
        $this->postService->save($expectedPost);

        // then
        $expectedPostId = $expectedPost->getId();
        $resultPost = $this->entityManager->createQueryBuilder()
            ->select('post')
            ->from(Post::class, 'post')
            ->where('post.id = :id')
            ->setParameter(':id', $expectedPostId, Types::INTEGER)
            ->getQuery()
            ->getSingleResult();

        $this->assertEquals($expectedPost, $resultPost);
    }

    /**
     * Test delete.
     *
     * @throws OptimisticLockException|ORMException
     */
    public function testDelete(): void
    {
        // given
        $category = new Category();
        $category->setTitle('Test Category');
        $this->entityManager->persist($category);
        $this->entityManager->flush();

        $user = $this->createUser(['ROLE_ADMIN']);

        $date = new \DateTimeImmutable();

        $postToDelete = new Post();
        $postToDelete->setTitle('Test Post');
        $postToDelete->setContents('Lorem ipsum dolor sit amet');
        $postToDelete->setCategory($category);
        $postToDelete->setAuthor($user);
        $postToDelete->setCreatedAt($date);
        $this->entityManager->persist($postToDelete);
        $this->entityManager->flush();
        $deletedPostId = $postToDelete->getId();

        // when
        $this->postService->delete($postToDelete);

        // then
        $resultPost = $this->entityManager->createQueryBuilder()
            ->select('post')
            ->from(Post::class, 'post')
            ->where('post.id = :id')
            ->setParameter(':id', $deletedPostId, Types::INTEGER)
            ->getQuery()
            ->getOneOrNullResult();

        $this->assertNull($resultPost);
    }

    /**
     * Test pagination empty list.
     */
    public function testGetPaginatedList(): void
    {
        // given
        $page = 1;
        $dataSetSize = 3;
        $expectedResultSize = 3;

        $user = $this->createUser(['ROLE_ADMIN']);

        $counter = 0;
        while ($counter < $dataSetSize) {
            $category = new Category();
            $expectedPost = new Post();
            $expectedPost->setTitle('Test Post');
            $expectedPost->setContents('Lorem ipsum dolor sit amet');
            $expectedPost->setCategory($category);
            $expectedPost->setAuthor($user);

            $category->setTitle('Test Category'.$counter);
            $this->entityManager->persist($category);
            $this->entityManager->flush();

            $this->postService->save($expectedPost);

            ++$counter;
        }

        // when
        $result = $this->postService->getPaginatedList($page);

        // then
        $this->assertEquals($expectedResultSize, $result->count());
    }

    /**
     * Function createUser().
     * @param array $roles
     * @return User
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
