<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

/**
 * Category class tests.
 */
class CategoryEntityTest extends TestCase
{
    /**
     * Test can get and set data.
     */
    public function testCanGetAndSetData(): void
    {
        $testedCategory = new Category();
        $testedCategory->setTitle('Test Category');

        self::assertSame('Test Category', $testedCategory->getTitle());
        self::assertSame($testedCategory->getId(), $testedCategory->getId());
    }
}
