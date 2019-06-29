<?php

namespace App\Model\User\Entity\User;

use DateTimeImmutable;
use Webmozart\Assert\Assert;
/**
 * Description of ResetToken
 *
 * @author ali
 */
class ResetToken {
    
    private $token;
    
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
}
