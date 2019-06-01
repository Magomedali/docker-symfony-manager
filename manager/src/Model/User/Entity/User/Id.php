<?php
namespace App\Model\User\Entity\User;

/**
 * Description of Id
 *
 * @author ali
 */
class Id {
    
    private $value;
    
    
    public function __construct($id) {
        $this->value = $id;
    }
    
    
    public function value()
    {
        return $this->value;
    }
    
    public static function next():self
    {
        return new self(\Ramsey\Uuid\Uuid::uuid4()->toString());
    }
}
