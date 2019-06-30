<?php
declare(strict_types=1);
namespace App\Model\User\UseCase\SignUp\Request;

use App\Model\User\Entity\User\{User,Email,Id,Token,UserRepository};
use App\Model\User\Service\{PasswordHasher,ConfirmTokenizer,ConfirmTokenSender};
use App\Model\User\Flusher;
/**
 * Description of Handler
 *
 * @author ali
 */
class Handler {
    
    private $users;
    
    
    private $hasher;
    
    
    private $flusher;
    
    
    private $sender;
    
    
    private $tokenizer;
    
    
    public function __construct(UserRepository $users,PasswordHasher $hasher,ConfirmTokenizer $tokenizer,ConfirmTokenSender $sender, Flusher $flusher)
    {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->flusher = $flusher;
        $this->sender = $sender;
        $this->tokenizer = $tokenizer;
    }
    
    public function handle(Command $command): void
    {
        $email = new Email($$command->email);
        $token = $this->tokenizer->generate();
        
        if($this->users->hasByEmail($email))
            throw new \DomainException("User already exists!");
        
        $user = User::signUpByEmail(
                Id::next(),
                $email,
                new Token($token),
                $this->hasher->hash($command->password)
        );
        
        $this->users->add($user);
        
        $this->sender->send($email,$token);
        $this->flusher->flush();
    }
}
