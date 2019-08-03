<?php
namespace App\Model\User\Entity\User;

/**
 * Description of Email
 *
 * @author ali
 */
class Email {
    private $value;
    
    
    public function __construct($value) {
        
        $this->value = mb_strtolower($value);
    }
    
    
    public function getValue()
    {
        return $this->value;
    }
}
