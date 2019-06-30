<?php
declare(strict_types=1);
namespace App\Tests\Unit\Model\User\Entity\User\Network;

use App\Model\User\Entity\User\{User,Id,Email,Token,Network};
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;
 
class AuthTest extends TestCase
{
    public function testSuccess(): void
    {
        
        $user = UserBuilder::instance()->viaNetwork($network = "vk", $identity = "123456789")->build();
        
        
        $this->assertCount(1,$networks = $user->getNetworks());
        $this->assertInstanceOf(Network::class, $first = reset($networks));
        
        $this->assertEquals($network,$first->getNetwork());
        $this->assertEquals($identity,$first->getIdentity());
        $this->assertTrue($user->isActive());
    }
    
}