<?php
/**
 * Post service.
 */

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class PostService.
 */
class PostService implements PostServiceInterface
{
    /**
     * Constructor.
     *
     * @param PostRepository           $postRepository  Post repository
     * @param PaginatorInterface       $paginator       Paginator interface
     * @param CategoryServiceInterface $categoryService Category service interface
     */
    public function __construct(
        /**
         * Post repository.
         */
        private readonly PostRepository $postRepository,
        /**
         * Paginator.
         */
        private readonly PaginatorInterface $paginator,
        /**
         * Category service.
         */
        private readonly CategoryServiceInterface $categoryService
    ) {
    }

    /**
     * Get paginated list.
     *
     * @param int   $page    Page
     * @param array $filters Filters
     *
     * @return PaginationInterface Paginator Interface
     *
     * @throws NonUniqueResultException
     */
    public function getPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->postRepository->queryAll($filters),
            $page,
            PostRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Post $post Post entity
     */
    public function save(Post $post): void
    {
        if (null == $post->getId()) {
            $post->setCreatedAt(new \DateTimeImmutable());
        }

        $this->postRepository->save($post);
    }

    /**
     * Delete entity.
     *
     * @param Post $post Post entity
     */
    public function delete(Post $post): void
    {
        $this->postRepository->delete($post);
    }

    /**
     * Prepare filters for the posts list.
     *
     * @param array $filters Filters
     *
     * @return array Returns array
     *
     * @throws NonUniqueResultException
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['category_id'])) {
            $category = $this->categoryService->findOneById($filters['category_id']);
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        return $resultFilters;
    }
}
