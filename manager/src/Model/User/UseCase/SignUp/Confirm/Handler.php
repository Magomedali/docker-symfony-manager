<?php
declare(strict_types=1);
namespace App\Model\User\UseCase\SignUp\Confirm;

use App\Model\User\Entity\User\{User,Token,UserRepository};
use App\Model\User\Flusher;
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
        $email = new Email($$command->email);
        $token = $this->tokenizer->generate();
        
        if($user = $this->users->findByConfirmToken(new Token($command->token)))
            throw new \DomainException("User not found or confirmed already!");
        
        
        $user->confirmToken();
        
        $this->flusher->flush();
    }
}
