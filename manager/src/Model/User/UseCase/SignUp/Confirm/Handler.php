<?php
declare(strict_types=1);
namespace App\Model\User\UseCase\SignUp\Confirm;

use App\Model\User\Entity\User\{User,Email,Token,UserRepository};
use App\Model\Flusher;
/**
 * Description of Handler
 *
 * @author ali
 */
class Handler {
    
    private $users;
    
    
    private $flusher;
    
    
    public function __construct(UserRepository $users, Flusher $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }
    
    public function handle(Command $command): void
    {
        
        if(!$user = $this->users->findByConfirmToken($command->token))
            throw new \DomainException("User not found or confirmed already!");
        
        $user->confirmToken();
        
        $this->flusher->flush();
    }
}
