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
    
    
    public function value()
    {
        return $this->value;
    }
}
