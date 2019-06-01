<?php
namespace App\Model\User\Entity\User;

/**
 * Description of UserRepository
 *
 * @author ali
 */
interface UserRepository {
    
    
    public function hasByEmail(Email $email):bool;
    
    
    public function add(User $user):void;
    
    public function findByConfirmToken(Token $token): ?User;
}
