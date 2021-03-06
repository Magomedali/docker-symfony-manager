<?php
namespace App\DataFixtures;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Role;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\Token;
use App\Model\User\Entity\User\Id;
use App\Model\User\Service\PasswordHasher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class UserFixture extends Fixture
{
    private $hasher;
    
    public function __construct(PasswordHasher $hasher)
    {
        $this->hasher = $hasher;
    }
    

    public function load(ObjectManager $manager): void
    {
        $hash = $this->hasher->hash('12345qwE');
        
        $user = User::signUpByEmail(
            Id::next(),
            new Email('web-ali@yandex.ru'),
            new Token('token'),
            $hash
        );
         
        $user->confirmToken();
        
        $user->changeRole(Role::admin());
        
        $manager->persist($user);
        $manager->flush();
    }
}