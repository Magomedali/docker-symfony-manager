<?php
namespace App\Model\User\Entity\User;

/**
 * Description of Token
 *
 * @author ali
 */
class Token {
    
    
    private $value;
    
    
    public function __construct($value) {
        $this->value = $value;
    }
    
    
    public function getValue()
    {
        return $this->value;
    }


    public function __toString(): string
    {
        return $this->getValue();
    }
}
