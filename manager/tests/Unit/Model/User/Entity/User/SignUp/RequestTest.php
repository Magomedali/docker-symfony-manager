<?php
declare(strict_types=1);
namespace App\Tests\Unit\Model\User\Entity\User\SignUp;

use App\Model\User\Entity\User\{User,Id,Email,Token};
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;
 
class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        
        $user = UserBuilder::instance()->viaEmail(
                    $email = new Email("test@ya.ru"),
                    $pass = "pass",
                    $token = new Token("token")
                )->build();
        
        $this->assertTrue($user->isWait());
        $this->assertFalse($user->isActive());
        
        // $this->assertEquals($id, $user->getId());
        $this->assertTrue($user->getRole()->isUser());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($token, $user->getConfirmToken());
        $this->assertEquals($pass, $user->getPasswordHash());
    }
}