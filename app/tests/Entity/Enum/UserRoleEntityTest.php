<?php

/**
 * This test file is a part of project made as a part of the ZTP course completion.
 *
 * (c) Michał Fudali <michal.fudali@student.uj.edu.pl>
 */

namespace App\Tests\Entity\Enum;

use App\Entity\Enum\UserRole;
use PHPUnit\Framework\TestCase;

/**
 * UserRole enum tests.
 */
class UserRoleEntityTest extends TestCase
{
    /**
     * Test UserRole values.
     */
    public function testUserRoleValues(): void
    {
        $this->assertEquals('ROLE_USER', UserRole::ROLE_USER->value);
        $this->assertEquals('ROLE_ADMIN', UserRole::ROLE_ADMIN->value);
    }

    /**
     * Test UserRole labels.
     */
    public function testUserRoleLabels(): void
    {
        $this->assertEquals('label.role_user', UserRole::ROLE_USER->label());
        $this->assertEquals('label.role_admin', UserRole::ROLE_ADMIN->label());
    }
}
