<?php

/**
 * This test file is a part of project made as a part of the ZTP course completion.
 *
 * (c) Michał Fudali <michal.fudali@student.uj.edu.pl>
 */

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * User class tests.
 */
class UserEntityTest extends TestCase
{
    /**
     * Test can get and set data.
     */
    public function testCanGetAndSetData(): void
    {
        $testUser = new User();
        $testUser->setEmail('test@test.com');
        $testUser->setPassword('password');
        $testUser->setRoles(['ROLE_USER']);

        self::assertEquals('test@test.com', $testUser->getUserIdentifier());
        self::assertEquals('test@test.com', $testUser->getEmail());
        self::assertEquals('password', $testUser->getPassword());
        self::assertEquals(['ROLE_USER'], $testUser->getRoles());
        self::assertEquals('test@test.com', $testUser->getUsername());
        self::assertNull($testUser->getSalt());

        $testUser->eraseCredentials();
        self::assertNull($testUser->eraseCredentials());
    }
}
