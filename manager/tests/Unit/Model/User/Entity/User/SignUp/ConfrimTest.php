<?php
declare(strict_types=1);
namespace App\Tests\Unit\Model\User\Entity\User\SignUp;

use App\Model\User\Entity\User\{User,Id,Email,Token};
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;
 
class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $user = UserBuilder::instance()->viaEmail()->build();
        
        $this->assertTrue($user->isWait());
        $this->assertFalse($user->isActive());
        
        $user->confirmToken();
        
        $this->assertFalse($user->isWait());
        $this->assertTrue($user->isActive());
    }
    
    
    public function testAlready(): void
    {
        $user = UserBuilder::instance()->viaEmail()->confirmed()->build();

        $this->expectExceptionMessage("User is already confirmed!");
        $user->confirmToken();
        
    }
}