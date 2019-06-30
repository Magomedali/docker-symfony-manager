<?php
declare(strict_types=1);
namespace App\Model\User\Entity\User;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author ali
 */
class User {
    
    const STATUS_NEW = 0;
    const STATUS_WAIT = 1;
    const STATUS_ACTIVE = 2;
    
    
    
    /**
     * @var string
     */
    private $id;
    
    
    private $created_at;
    
    /**
    * @var string
    */
    private $email;
    
    
    /**
     * @var string
     */
    private $passwordHash;
    
    /**
     * @var Role
     */
    private $role;
    
    /**
     * @var string
     */
    private $confirmToken;
    
    
    private $resetToken;
    
    
    private $networks;
    
    
    private $status;
    
    
    
    private function __construct(Id $id)
    {
        $this->id = $id;
        $this->created_at = new DateTimeImmutable();
        $this->role = Role::user();
        $this->networks = new ArrayCollection();
    }
    
    public static function signUpByEmail(Id $id,Email $email,Token $confirmToken, string $hash):self
    {
        $user = new Self($id);
        $user->email = $email;
        $user->passwordHash = $hash;
        $user->confirmToken = $confirmToken;
        $user->status = self::STATUS_WAIT;
        return $user;
    }
    
    
    
    public static function signUpByNetwork(Id $id,string $network,string $identity):self
    {
        $user = new Self($id);
        $user->attachNetwork($network,$identity);
        $user->status = self::STATUS_ACTIVE;
        return $user;
    }
    
    
    public function getId(): Id
    {
        return $this->id;
    }
    
    
    
    public function getEmail(): Email
    {
        return $this->email;
    }
    
    
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
    
    
    public function getResetToken(): ?ResetToken
    {
        return $this->resetToken;
    }
    
    
    public function getConfirmToken():Token
    {
        return $this->confirmToken;
    }


    public function getRole(): Role
    {
        return $this->role;
    }
    

    
    
    
    public function getNetworks():array
    {
        return $this->networks->toArray();
    }
    
    
    
    public function isWait():bool
    {
        return $this->status === self::STATUS_WAIT;
    }
    
    
    public function isNew():bool
    {
        return $this->status === self::STATUS_NEW;
    }
    
    
    public function isActive():bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
    
    
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->created_at;
    }
    


    public function changeRole(Role $role): void
    {
        if ($this->role->isEqual($role)) {
            throw new \DomainException('Role is already same.');
        }
        $this->role = $role;
    }

    
    
    public function confirmToken(): void
    {
        if(!$this->isWait())
            throw new \DomainException("User is already confirmed!");
        
        $this->status = self::STATUS_ACTIVE;
        $this->confirmToken = null;
    }
    
    
    
    public function attachNetwork(string $network, string $identity):void
    {
        foreach($this->getNetworks() as $existing)
        {
            if($existing->isForNetwork($network))
                throw new \DomainException("Network is already attached!");
        }
        
        $this->networks->add(new Network($this,$network,$identity));
    }
    
    
    
    public function requestPasswordReset(ResetToken $token, DateTimeImmutable $date):void
    {
        if(!$this->isActive())
            throw new \DomainException("User is not active");
        
        if(!$this->email)
            throw new \DomainException("Email is not specified.");
        
        if($this->resetToken && !$this->resetToken->isExpiredTo($date))
            throw new \DomainException("Resetting is already requested.");
        
        $this->resetToken = $token;
    }
    
    
    
    public function passwordReset(DateTimeImmutable $date, string $hash): void
    {
        if(!$this->resetToken)
            throw new \DomainException("Resetting is not requested.");
        
        if($this->resetToken->isExpiredTo($date))
            throw new \DomainException("Reset token is expired.");
        
        $this->passwordHash = $hash;
        $this->resetToken = null;
    }
}
