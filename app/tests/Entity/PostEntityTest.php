<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\User;
use Monolog\Test\TestCase;

/**
 * Post class tests.
 */
class PostEntityTest extends TestCase
{
    /**
     * Test can get and set data.
     */
    public function testCanGetAndSetData(): void
    {
        $testedPost = new Post();
        $testedPost->setTitle('Test Post');
        $testedPost->setContents('Test Post contents');
        $testedPost->setCreatedAt(new \DateTimeImmutable());
        $testedPost->setCategory(new Category());
        $testedPost->setAuthor(new User());
        $testedPost->addTag($testTag = new Tag());
        $testedPost->addComment($testComment = new Comment());
        $testedPost->removeTag($testTag);
        $testedPost->removeComment($testComment);

        self::assertSame('Test Post', $testedPost->getTitle());
        self::assertSame('Test Post contents', $testedPost->getContents());
        self::assertSame($testedPost->getCategory(), $testedPost->getCategory());
        self::assertSame($testedPost->getCreatedAt(), $testedPost->getCreatedAt());
        self::assertSame($testedPost->getAuthor(), $testedPost->getAuthor());
        self::assertSame($testedPost->getComments(), $testedPost->getComments());
        self::assertSame($testedPost->getTags(), $testedPost->getTags());
    }
}
