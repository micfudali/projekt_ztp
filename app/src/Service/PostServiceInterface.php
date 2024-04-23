<?php
/**
 * Post service interface.
 */

namespace App\Service;

use App\Entity\Post;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface PostServiceInterface.
 */
interface PostServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int   $page    Page number
     * @param array $filters Filters
     *
     * @return PaginationInterface Pagination interface
     */
    public function getPaginatedList(int $page, array $filters = []): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Post $post Post entity
     */
    public function save(Post $post): void;

    /**
     * Delete post.
     *
     * @param Post $post Post entity
     */
    public function delete(Post $post): void;
}
