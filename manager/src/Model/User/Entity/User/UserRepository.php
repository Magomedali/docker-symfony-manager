<?php
namespace App\Model\User\Entity\User;

/**
 * Description of UserRepository
 *
 * @author ali
 */
interface UserRepository {
    
    public function get(Id $id): User;
    
    public function hasByEmail(Email $email):bool;
    
    public function hasByNetworkIdentity(string $network, string $identity): bool;
    
    public function getByEmail(Email $email):User;
    
    public function add(User $user):void;
    
    public function findByConfirmToken(Token $token): ?User;
    
    public function findByResetToken(ResetToken $token): ?User;
    
    public function findByNetworkIdentity(string $network, string $identity): ?User;
}
