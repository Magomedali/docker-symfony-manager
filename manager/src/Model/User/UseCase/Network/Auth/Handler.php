<?php
declare(strict_types=1);
namespace App\Model\User\UseCase\Network\Auth;

use App\Model\User\Entity\User\{User,Id,Token,UserRepository};
use App\Model\User\Service\{PasswordHasher,ConfirmTokenizer,ConfirmTokenSender};
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
        
        if($this->users->hasByNetworkIdentity($command->network,$command->identity))
            throw new \DomainException("User already exists!");
        
        $user = User::signUpByNetwork(Id::next(),$command->network,$command->identity);
        
        $this->users->add($user);
        
        $this->flusher->flush();
    }
}
