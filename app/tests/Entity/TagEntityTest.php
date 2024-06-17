<?php

/**
 * This test file is a part of project made as a part of the ZTP course completion.
 *
 * (c) Michał Fudali <michal.fudali@student.uj.edu.pl>
 */

namespace App\Tests\Entity;

use App\Entity\Tag;
use PHPUnit\Framework\TestCase;

/**
 * Tag entity tests.
 */
class TagEntityTest extends TestCase
{
    /**
     * Test can get and set data.
     */
    public function testCanGetAndSetData(): void
    {
        $testedTag = new Tag();
        $testedTag->setTitle('Test tag');

        self::assertSame($testedTag->getId(), $testedTag->getId());
        self::assertSame('Test tag', $testedTag->getTitle());
    }
}
