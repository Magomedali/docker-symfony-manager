<?php

namespace App\Model\User\Service;


use DateTimeImmutable;
use DateInterval;
use Ramsey\Uuid\Uuid;
use App\Model\User\Entity\User\ResetToken;
/**
 * Description of ResetTokenizer
 *
 * @author ali
 */
class ResetTokenizer {
    
    private $interval;
    
    public function __construct(DateInterval $interval) {
        $this->interval = $interval;
        
        return new ResetToken(Uuid::uuid4()->toString(),(new DateTimeImmutable())->add($interval));
    }
    
    
    
    public function generate():ResetToken
    {
        return new ResetToken(Uuid::uuid4()->toString(),(new DateTimeImmutable())->add($this->interval));
    }
}
