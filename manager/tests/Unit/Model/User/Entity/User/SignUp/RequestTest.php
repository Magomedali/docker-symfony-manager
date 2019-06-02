<?php
declare(strict_types=1);
namespace App\Tests\Unit\Model\User\Entity\User\SignUp;

use App\Model\User\Entity\User\{User,Id,Email,Token};
use PHPUnit\Framework\TestCase;
 
class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = new User($id = new Id("guid"));
        
        $this->assertTrue($user->isNew());
        
        $user->signUpByEmail(
                $email = new Email("test@ya.ru"), 
                $token = new Token("token"),
                $pass = "pass");
        
        $this->assertTrue($user->isWait());
        $this->assertFalse($user->isActive());
        
        $this->assertEquals($id, $user->getId());
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($token, $user->getConfirmToken());
        $this->assertEquals($pass, $user->getPasswordHash());
    }
}