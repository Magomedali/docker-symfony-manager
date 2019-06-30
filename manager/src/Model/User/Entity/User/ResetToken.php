<?php

namespace App\Model\User\Entity\User;

use DateTimeImmutable;
use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of ResetToken
 * @author ali
 *
 * @ORM\Embeddable
 */
class ResetToken {
    
    /**
     * @var string       
     * @ORM\Column(type="string", nullable=true)
     */  
    private $token;
    

    /**
     * @var string       
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */ 
    private $expires;
    


    
    public function __construct(string $token, DateTimeImmutable $expires) {
        
        Assert::notEmpty($token);
        $this->token = $token;
        $this->expires = $expires;
    }
    
    
    public function getToken():string
    {
        return $this->token;
    }
    
    
    
    public function isExpiredTo(DateTimeImmutable $date):bool
    {
        return $this->expires <= $date;
    }


    /**
     * @internal for postLoad callback
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->token);
    }
}
