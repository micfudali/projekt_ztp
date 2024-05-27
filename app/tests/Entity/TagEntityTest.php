<?php

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
