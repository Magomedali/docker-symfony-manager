<?php
declare(strict_types=1);
namespace App\Tests\Unit\Model\User\Entity\User\SignUp;

use App\Model\User\Entity\User\{User,Id,Email,Token};
use PHPUnit\Framework\TestCase;
 
class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->buildSignedUser();
        
        $this->assertTrue($user->isWait());
        $this->assertFalse($user->isActive());
        
        $user->confirmToken();
        
        $this->assertFalse($user->isWait());
        $this->assertTrue($user->isActive());
    }
    
    
    public function testAlready(): void
    {
        $user = $this->buildSignedUser();
        
        
        $user->confirmToken();
        $this->expectExceptionMessage("User is already confirmed!");
        $user->confirmToken();
        
    }
    
    
    private function buildSignedUser():User
    {
        return new User($id = new Id("guid"),
                $email = new Email("test@ya.ru"), 
                $token = new Token("token"),
                $pass = "pass");
    }
}