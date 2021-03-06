<?php
declare(strict_types=1);
namespace App\Model\User\UseCase\Reset\Request;

use DateTimeImmutable;
use App\Model\User\Entity\User\{UserRepository,Email};
use App\Model\Flusher;
use App\Model\User\Service\{ResetTokenizer,ResetTokenSender};
/**
 * Description of Handler
 *
 * @author ali
 */
class Handler {
    
    private $users;
    
    private $flusher;
    
    private $sender;
    
    private $tokenizer;
    
    public function __construct(UserRepository $users,Flusher $flusher,ResetTokenizer $resetTokenizer,ResetTokenSender $sender) {
        $this->users = $users;
        $this->flusher = $flusher;
        
        $this->tokenizer = $resetTokenizer;
        $this->sender = $sender;
    }


    public function handle(Command $command)
    {
        $user = $this->users->getByEmail(new Email($command->email));
        
        $user->requestPasswordReset($this->tokenizer->generate(), new DateTimeImmutable());
        
        $this->flusher->flush();
        
        $this->sender->send($user->getEmail(),$user->getResetToken());
    }
}
