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
     * @var string
     */
    private $confirmToken;
    
    
    private $resetToken;
    
    
    private $networks;
    
    
    private $status;
    
    
    
    public function __construct(Id $id)
    {
        $this->id = $id;
        $this->created_at = new DateTimeImmutable();
        $this->status = self::STATUS_NEW;
        $this->networks = new ArrayCollection();
    }
    
    public function signUpByEmail(Email $email,Token $confirmToken, string $hash):void
    {
        if(!$this->isNew())
            throw new \DomainException("User is already signed");
        
        $this->email = $email;
        $this->passwordHash = $hash;
        $this->confirmToken = $confirmToken;
        $this->status = self::STATUS_WAIT;
    }
    
    
    
    public function signUpByNetwork(string $network,string $identity):void
    {
        if(!$this->isNew())
            throw new \DomainException("User is already signed");
        
        $this->attachNetwork($network,$identity);
        $this->status = self::STATUS_ACTIVE;
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
