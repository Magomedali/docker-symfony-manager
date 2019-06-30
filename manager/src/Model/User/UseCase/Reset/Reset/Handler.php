<?php
declare(strict_types=1);
namespace App\Model\User\UseCase\Reset\Reset;

use DateTimeImmutable;
use App\Model\User\Entity\User\{User,UserRepository,ResetToken};
use App\Model\Flusher;
use App\Model\User\Service\PasswordHasher;
/**
 * Description of Handler
 *
 * @author ali
 */
class Handler {
    
    private $users;
    
    private $flusher;
    
    private $hasher;
    
    public function __construct(UserRepository $users,Flusher $flusher,PasswordHasher $sender) {
        $this->users = $users;
        $this->flusher = $flusher;
        $this->hasher = $hasher;
    }


    public function handler(Command $command)
    {
        if(!$user = $this->users->findByResetToken(new ResetToken($command->token)))
                throw new \DomainException("Incorrect or confirmed token.");
        
        $user->passwordReset(new DateTimeImmutable(),$this->hasher->hash($command->password));
        
        $this->flusher->flush();
    }
}
