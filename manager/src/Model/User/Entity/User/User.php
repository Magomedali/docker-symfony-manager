<?php
declare(strict_types=1);
namespace App\Model\User\Entity\User;

use DateTimeImmutable;
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
    
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 0;
    
    
    
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
    
    
    
    private $status;
    
    
    
    public function __construct(Id $id,Email $email,Token $confirmToken, string $hash)
    {
        $this->id = $id;
        $this->email = $email;
        $this->passwordHash = $hash;
        $this->confirmToken = $confirmToken;
        $this->status = self::STATUS_WAIT;
        $this->created_at = new DateTimeImmutable();
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
    
    
    public function getConfirmToken():Token
    {
        return $this->confirmToken;
    }
    
    
    
    public function isWait():bool
    {
        return $this->status === self::STATUS_WAIT;
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
}
