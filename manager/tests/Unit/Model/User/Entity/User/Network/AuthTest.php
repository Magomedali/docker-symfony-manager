<?php
declare(strict_types=1);
namespace App\Tests\Unit\Model\User\Entity\User\Network;

use App\Model\User\Entity\User\{User,Id,Email,Token,Network};
use PHPUnit\Framework\TestCase;
 
class AuthTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = new User($id = new Id("guid"));
        
        $this->assertTrue($user->isNew());
        
        $user->signUpByNetwork($network = "vk", $identity = "123456789");
        
        $this->assertCount(1,$networks = $user->getNetworks());
        $this->assertInstanceOf(Network::class, $first = reset($networks));
        
        $this->assertEquals($network,$first->getNetwork());
        $this->assertEquals($identity,$first->getIdentity());
    }
    
    
    public function testAlready(): void
    {
        $user = new User($id = new Id("guid"));
        
        $user->signUpByNetwork($network = "vk", $identity = "123456789");
        
        $this->expectExceptionMessage("User is already signed");
        
        $user->signUpByNetwork($network = "vk", $identity = "123456789");
        
    }
    
}