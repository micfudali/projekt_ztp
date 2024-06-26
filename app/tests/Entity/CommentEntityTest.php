<?php

/**
 * This test file is a part of project made as a part of the ZTP course completion.
 *
 * (c) Michał Fudali <michal.fudali@student.uj.edu.pl>
 */

namespace App\Tests\Entity;

use App\Entity\Comment;
use App\Entity\Post;
use PHPUnit\Framework\TestCase;

/**
 * Comment class tests.
 */
class CommentEntityTest extends TestCase
{
    /**
     * Test can get and set data.
     */
    public function testCanGetAndSetData(): void
    {
        $testedComment = new Comment();
        $testedComment->setEmail('test@test.com');
        $testedComment->setNick('Test Nick');
        $testedComment->setContents('Test Contents');
        $testedComment->setPost(new Post());

        self::assertSame($testedComment->getPost()->getId(), $testedComment->getId());
        self::assertSame('test@test.com', $testedComment->getEmail());
        self::assertSame('Test Nick', $testedComment->getNick());
        self::assertSame('Test Contents', $testedComment->getContents());
        self::assertSame($testedComment->getPost(), $testedComment->getPost());
    }
}
