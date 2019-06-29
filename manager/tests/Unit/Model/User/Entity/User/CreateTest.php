<?php
declare(strict_types=1);
namespace App\Tests\Unit\Model\User\Entity\User;

use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;


class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = new User(
            $id = Id::next()
        );
        self::assertTrue($user->isNew());
        self::assertEquals($id, $user->getId());
    }
}